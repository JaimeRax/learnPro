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

                // Obtener grados, secciones y cursos
                $degrees = Degree::all();
                $sections = Sections::all();
                $courses = Courses::all(); // Asegúrate de que tengas este modelo

                // Obtener actividades relacionadas con las asignaciones generales
                $activities = Activity::whereIn('general_assignment_id', $generalAssignments)
                    ->whereHas('generalAssignment', function ($query) use ($degreeId, $sectionId, $courseId) {
                        $query->where('degrees_id', $degreeId)->where('section_id', $sectionId)->where('course_id', $courseId);
                    })
                    ->get();

                $students = Student::whereHas('studentAssignments', function ($query) use ($generalAssignments) {
                    $query->whereIn('general_assignment_id', $generalAssignments);
                })->get();

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
        // Validar los datos de entrada
        $request->validate([
            'grado' => 'required|exists:degrees,id',
            'seccion' => 'required|exists:sections,id',
            'curso' => 'required|exists:courses,id'
        ]);

        try {
            // Obtener los IDs de grado, sección y curso
            $degreeId = $request->grado;
            $sectionId = $request->seccion;
            $courseId = $request->curso;

            $user = Auth::user();

            // Obtener las asignaciones generales del docente
            $generalAssignments = GeneralAssignment::where('teachers_id', $user->id)
                ->where('degrees_id', $degreeId)
                ->where('section_id', $sectionId)
                ->where('course_id', $courseId)
                ->pluck('id');

            // Obtener actividades relacionadas
            $activities = Activity::whereIn('general_assignment_id', $generalAssignments)
                ->whereHas('generalAssignment', function ($query) use ($degreeId, $sectionId, $courseId) {
                    $query->where('degrees_id', $degreeId)->where('section_id', $sectionId)->where('course_id', $courseId);
                })
                ->get();

            // Obtener estudiantes relacionados
            $students = Student::whereHas('studentAssignments', function ($query) use ($generalAssignments) {
                $query->whereIn('general_assignment_id', $generalAssignments);
            })->get();

            $ratings = Ratings::whereIn('activity_id', $activities->pluck('id'))
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->groupBy('student_id')
            ->map(fn($studentRatings) => $studentRatings->keyBy('activity_id'));

        // Pasar los datos a la vista PDF
        $pdf = PDF::loadView('pdf.reportRatings', [
            'students' => $students,
            'activities' => $activities,
            'ratings' => $ratings, // Asegúrate de pasar las calificaciones
            'degreeId' => $degreeId,
            'sectionId' => $sectionId,
            'courseId' => $courseId
        ]);

            // Generar el PDF y descargarlo
            return $pdf->download('calificaciones.pdf');
        } catch (\Exception $e) {
            return redirect('/ratings')->with('error', 'Ocurrió un problema al generar el PDF.');
        }
    }
}
