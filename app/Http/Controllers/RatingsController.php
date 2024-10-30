<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Degree;
use App\Models\Courses;
use App\Models\Ratings;
use App\Models\Student;
use App\Models\Activity;
use App\Models\Sections;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\GeneralAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
    public function listRatings()
    {
        try {
            $user = Auth::user();
            $degreeId = request()->query('degree_id');
            $sectionId = request()->query('section_id');
            $courseId = request()->query('course_id'); // Agregado para filtrar por curso
            $search = request()->query('search');

            if ($user && $user->hasRole('docente')) {
                // Obtener las asignaciones generales del docente
                $generalAssignments = GeneralAssignment::where('teachers_id', $user->id)
                    ->when($degreeId, fn($query) => $query->where('degrees_id', $degreeId))
                    ->when($sectionId, fn($query) => $query->where('section_id', $sectionId))
                    ->when($courseId, fn($query) => $query->where('course_id', $courseId))
                    ->pluck('id');

                // Consulta de estudiantes
                $students = Student::whereIn('state', [1, 2])
                    ->whereHas('studentAssignments', fn($query) => $query->whereIn('general_assignment_id', $generalAssignments))
                    ->when($search, fn($query) => $query->where('first_name', 'LIKE', "%{$search}%"))
                    ->paginate(10)
                    ->appends(compact('degreeId', 'sectionId', 'courseId', 'search'));

                // Obtener grados, secciones y cursos
                $degrees = Degree::all();
                $sections = Sections::all();
                $courses = Courses::all(); // Asegúrate de que tengas este modelo

                // Obtener actividades relacionadas con las asignaciones generales
                $activities = Activity::whereIn('general_assignment_id', $generalAssignments)->get();
                $ratings = Ratings::whereIn('activity_id', $activities->pluck('id'))->whereIn('student_id', $students->pluck('id'))->get()->groupBy('student_id')->map(fn($studentRatings) => $studentRatings->keyBy('activity_id'));

                return view('ratings.listRatings', compact('students', 'activities', 'degrees', 'sections', 'courses', 'ratings'));
            }

            return redirect('/ratings');
        } catch (\Exception $e) {
            return redirect('/ratings')->with('error', 'Ocurrió un problema al listar las calificaciones.');
        }
    }

    public function editRatings(Request $request)
    {
        try {
            // Validar que cada entrada en 'ratings' tenga el campo 'score_obtained'
            $validatedData = $request->validate([
                'ratings.*.*.score_obtained' => 'nullable|numeric'
            ]);

            foreach ($request->ratings as $studentId => $studentRatings) {
                foreach ($studentRatings as $activityId => $ratingData) {
                    // Aquí busca la calificación usando el activity_id de la tabla ratings
                    $rating = Ratings::where('student_id', $studentId)->where('activity_id', $activityId)->first();

                    if ($rating) {
                        // Actualizar calificación existente
                        $rating->score_obtained = $ratingData['score_obtained'];
                        $rating->save();
                    } else {
                        // Crear nueva calificación si no existe
                        $rating = new Ratings([
                            'student_id' => $studentId,
                            'activity_id' => $activityId,
                            'score_obtained' => $ratingData['score_obtained']
                        ]);
                        $rating->save();
                    }
                }
            }

            return redirect('/ratings')->with('message', 'Calificaciones actualizadas correctamente.');
        } catch (\Exception $e) {
            Log::error('editRatings - Error: ' . $e->getMessage());
            return redirect('/ratings')->with('error', 'Ocurrió un problema al actualizar las calificaciones.');
        }
    }

    public function generateRatingsPDF(Request $request)
    {
        try {
            // Validar los datos de entrada
            $request->validate([
                'grado' => 'required|exists:degrees,id',
                'seccion' => 'required|exists:sections,id',
                'curso' => 'required|exists:courses,id',
            ]);

            // Obtener los estudiantes relacionados con las asignaciones
            $students = Student::whereIn('id', function ($query) use ($request) {
                $query->select('student_id')
                    ->from('tb_student_assignment')
                    ->whereIn('general_assignment_id', function ($subQuery) use ($request) {
                        $subQuery->select('id')
                            ->from('tb_general_assignment')
                            ->where('degrees_id', $request->grado)
                            ->where('section_id', $request->seccion)
                            ->where('course_id', $request->curso);
                    });
            })
            ->with(['ratings.activity']) // Asegúrate de que estas relaciones estén bien definidas en el modelo
            ->get();

            // Verificar si hay estudiantes
            if ($students->isEmpty()) {
                return redirect()->back()->with('error', 'No se encontraron estudiantes para los criterios seleccionados.');
            }

            // Generar el PDF por sección
            $pdf = PDF::loadView('pdf.reportRatings', compact('students'));

            return $pdf->download('reporte_calificaciones.pdf');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Capturar errores de validación
            Log::error('Validation error in generateRatingsPDF: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Error de validación: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Capturar cualquier otro error
            Log::error('Error generating PDF in generateRatingsPDF: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

}
