<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Degree;
use App\Models\Courses;
use App\Models\Ratings;
use App\Models\Student;
use App\Models\Activity;
use App\Models\Sections;
use Illuminate\Support\Str;
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

            // Enviar respuesta JSON en caso de éxito
            return response()->json(['success' => true, 'message' => 'Calificaciones actualizadas correctamente.']);
        } catch (\Exception $e) {
            Log::error('editRatings - Error: ' . $e->getMessage());

            // Enviar respuesta JSON en caso de error
            return response()->json(['success' => false, 'message' => 'Ocurrió un problema al actualizar las calificaciones.'], 500);
        }
    }

    public function generateRatingsPDF(Request $request)
{
    // Validar los datos de entrada, haciendo que todos sean opcionales
    $request->validate([
        'grado' => 'nullable|exists:degrees,id',
        'seccion' => 'nullable|exists:sections,id',
        'curso' => 'nullable|exists:courses,id'
    ]);

    try {
        Log::info('Iniciando generación de PDF de calificaciones.', [
            'grado' => $request->grado,
            'seccion' => $request->seccion,
            'curso' => $request->curso
        ]);

        // Obtener los IDs de grado, sección y curso
        $degreeId = $request->grado;
        $sectionId = $request->seccion;
        $courseId = $request->curso;

        // Obtener el nombre del grado, sección y curso solo si están presentes
        $gradoNombre = $degreeId ? Degree::find($degreeId)->name : '';
        $seccionNombre = $sectionId ? Sections::find($sectionId)->name : '';
        $cursoNombre = $courseId ? Courses::find($courseId)->name : '';

        $user = Auth::user();
        $username = $user->username;
        $fullName = "{$user->first_name} {$user->second_name} {$user->first_lastname} {$user->second_lastname}";
        $uuid = Str::uuid();
        Log::info('Usuario autenticado', ['user_id' => $user->id]);

        // Obtener las asignaciones generales del docente
        $generalAssignmentsQuery = GeneralAssignment::where('teachers_id', $user->id);

        if ($degreeId) {
            $generalAssignmentsQuery->where('degrees_id', $degreeId);
        }
        if ($sectionId) {
            $generalAssignmentsQuery->where('section_id', $sectionId);
        }
        if ($courseId) {
            $generalAssignmentsQuery->where('course_id', $courseId);
        }

        $generalAssignments = $generalAssignmentsQuery->pluck('id');
        Log::info('Asignaciones generales obtenidas', ['generalAssignments' => $generalAssignments]);

        // Obtener actividades relacionadas
        $activities = Activity::whereIn('general_assignment_id', $generalAssignments)
            ->whereHas('generalAssignment', function ($query) use ($degreeId, $sectionId, $courseId) {
                if ($degreeId) {
                    $query->where('degrees_id', $degreeId);
                }
                if ($sectionId) {
                    $query->where('section_id', $sectionId);
                }
                if ($courseId) {
                    $query->where('course_id', $courseId);
                }
            })
            ->get();
        Log::info('Actividades obtenidas', ['activities' => $activities->pluck('id')]);

        // Obtener estudiantes relacionados
        $students = Student::whereHas('studentAssignments', function ($query) use ($generalAssignments) {
            $query->whereIn('general_assignment_id', $generalAssignments);
        })->get();
        Log::info('Estudiantes obtenidos', ['students' => $students->pluck('id')]);

        // Obtener calificaciones
        $ratings = Ratings::whereIn('activity_id', $activities->pluck('id'))
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->groupBy('student_id')
            ->map(fn($studentRatings) => $studentRatings->keyBy('activity_id'));
        Log::info('Calificaciones obtenidas', ['ratings_count' => $ratings->count()]);

        // Pasar los datos a la vista PDF
        $pdf = PDF::loadView('pdf.reportRatings', [
            'students' => $students,
            'activities' => $activities,
            'ratings' => $ratings,
            'gradoNombre' => $gradoNombre,
            'seccionNombre' => $seccionNombre,
            'cursoNombre' => $cursoNombre,
            'courseId' => $courseId,
            'username' => $username,
            'uuid' => $uuid,
            'fullName' => $fullName
        ]);

        Log::info('PDF generado con éxito.');

        // Generar el PDF y descargarlo
        return $pdf->download('calificaciones.pdf');
    } catch (\Exception $e) {
        // Registrar el error en los logs
        Log::error('Error al generar el PDF de calificaciones', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return back()->with('error', 'Ocurrió un problema al generar el PDF. Por favor, inténtelo de nuevo.');
    }
}

}
