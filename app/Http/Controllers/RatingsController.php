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
        $grado = $request->grado;
        $seccion = $request->seccion;

        $user = Auth::user();
        $uuid = Str::uuid();

        // Realiza la consulta para obtener las actividades y calificaciones agrupadas por grado, sección y curso
        $results = DB::table('tb_student_assignment as sa')
            ->select(
                'sa.student_id AS estudiante_id',
                's.first_name AS estudiante', // Nombre del estudiante
                'ga.course_id AS curso_id',
                'c.name AS curso_nombre', // Nombre del curso
                'ga.degrees_id AS grado_id',
                'd.name AS grado_nombre', // Nombre del grado
                'sa.section_id AS seccion_id',
                'sec.name AS seccion_nombre', // Nombre de la sección
                'a.name AS actividad',
                'r.score_obtained AS calificacion'
            )
            ->join('tb_general_assignment as ga', 'sa.general_assignment_id', '=', 'ga.id')
            ->join('tb_activity as a', 'ga.id', '=', 'a.general_assignment_id')
            ->join('tb_ratings as r', 'a.id', '=', 'r.activity_id')
            ->join('tb_student as s', 'sa.student_id', '=', 's.id')
            ->join('users as u', 'ga.teachers_id', '=', 'u.id')
            ->join('degrees as d', 'ga.degrees_id', '=', 'd.id') // Join para obtener nombre del grado
            ->join('sections as sec', 'sa.section_id', '=', 'sec.id') // Join para obtener nombre de la sección
            ->join('courses as c', 'ga.course_id', '=', 'c.id') // Join para obtener nombre del curso
            ->where('u.id', $user->id)
            ->when($grado, function ($query, $grado) {
                return $query->where('ga.degrees_id', $grado);
            })
            ->when($seccion, function ($query, $seccion) {
                return $query->where('sa.section_id', $seccion);
            })
            ->orderBy('ga.degrees_id')  // Ordenar por grado
            ->orderBy('sa.section_id')  // Luego por sección
            ->orderBy('s.first_name')
            ->get()
            ->groupBy(function ($item) {
                return "{$item->grado_nombre}-{$item->seccion_nombre}-{$item->curso_nombre}";
            });

        // Transformar resultados a la estructura adecuada
        $formattedResults = [];
        foreach ($results as $key => $activities) {
            foreach ($activities as $activity) {
                $formattedResults[$key][$activity->estudiante]['estudiante'] = $activity->estudiante;
                $formattedResults[$key][$activity->estudiante]['actividades'][$activity->actividad] = $activity->calificacion;
            }
        }

        // Pasar los datos a la vista PDF
        $pdf = PDF::loadView('pdf.reportRatings', [
            'results' => $formattedResults,
            'uuid' => $uuid,
            'username' => $user->username,
            'fullName' => "{$user->first_name} {$user->second_name} {$user->first_lastname} {$user->second_lastname}",
        ]);

        return $pdf->download('calificaciones.pdf');
    }



}
