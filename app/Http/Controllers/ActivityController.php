<?php

namespace App\Http\Controllers;

use Svg\Tag\Rect;
use App\Models\Degree;
use App\Models\Courses;
use App\Models\Ratings;
use App\Models\Activity;
use App\Models\Sections;
use Illuminate\Http\Request;
use App\Models\GeneralAssignment;
use App\Models\StudentAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function listActivity(Request $request)
    {
        try {
            $degreeId = $request->query('degree_id');
            $sectionId = $request->query('section_id');
            $courseId = $request->query('course_id');
            $search = $request->query('search');

            // Consulta inicial de actividades
            $activities = Activity::where('state', 1) // Solo actividades activas/inactivas
            ->when($degreeId || $sectionId || $courseId, function ($query) use ($degreeId, $sectionId, $courseId) {
                // Filtrar por asignación general (general_assignment_id)
                return $query->whereHas('generalAssignment', function ($query) use ($degreeId, $sectionId, $courseId) {
                    if ($degreeId) {
                        $query->where('degrees_id', $degreeId);
                    }
                    if ($sectionId) {
                        $query->where('section_id', $sectionId);
                    }
                    if ($courseId) {
                        $query->where('course_id', $courseId);
                    }
                });
            })
                ->when($search, function ($query) use ($search) {
                    // Filtro de búsqueda por nombre
                    return $query->where('name', 'LIKE', "%{$search}%");
                })
                ->paginate(10)
                ->appends([
                    'degree_id' => $degreeId,
                    'section_id' => $sectionId,
                    'course_id' => $courseId,
                    'search' => $search
                ]);

            // Obtener datos para los selectores en la vista
            $degrees = Degree::all();
            $sections = Sections::all();
            $courses = Courses::all();

            // Retornar la vista con los datos necesarios
            return view('activity.listActivity', [
                'activities' => $activities,
                'degrees' => $degrees,
                'sections' => $sections,
                'courses' => $courses
            ]);
        } catch (\Exception $e) {
            return redirect('/activity')->with('error', 'Ocurrió un problema al listar las actividades.');
        }
    }

    public function showCreate(Request $request)
    {
        $degreeId = $request->query('degree_id');
        $sectionId = $request->query('section_id');
        $courseId = $request->query('course_id');
        $search = $request->query('search');

        // Consulta inicial de actividades
        $activities = Activity::where('state', 1) // Solo actividades activas/inactivas
        ->when($degreeId || $sectionId || $courseId, function ($query) use ($degreeId, $sectionId, $courseId) {
            // Filtrar por asignación general (general_assignment_id)
            return $query->whereHas('generalAssignment', function ($query) use ($degreeId, $sectionId, $courseId) {
                if ($degreeId) {
                    $query->where('degrees_id', $degreeId);
                }
                if ($sectionId) {
                    $query->where('section_id', $sectionId);
                }
                if ($courseId) {
                    $query->where('course_id', $courseId);
                }
            });
        })
            ->when($search, function ($query) use ($search) {
                // Filtro de búsqueda por nombre
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->paginate(10)
            ->appends([
                'degree_id' => $degreeId,
                'section_id' => $sectionId,
                'course_id' => $courseId,
                'search' => $search
            ]);

        // Obtener datos para los selectores en la vista
        $degrees = Degree::all();
        $sections = Sections::all();
        $courses = Courses::all();

        return view('activity.createActivity', [ 'activities' => $activities,
        'degrees' => $degrees,
        'sections' => $sections,
        'courses' => $courses]);
    }

    public function createActivity(Request $request)
    {
        try {
            $activities = $request->input('activities', []);
            Log::info('Iniciando proceso de creación de actividades.', ['total_activities' => count($activities)]);

            foreach ($activities as $index => $activityData) {
                Log::info("Procesando actividad #{$index}", ['activity_data' => $activityData]);

                // Validar cada actividad individualmente
                $validator = Validator::make($activityData, [
                    'name' => 'required|string|max:255',
                    'year' => 'required',
                    'date_entity' => 'required|date',
                    'bimester' => 'required',
                    'plucking' => 'required|integer',
                    'degree' => 'required|integer',
                    'section' => 'required|integer',
                    'course' => 'required|integer',
                ]);

                if ($validator->fails()) {
                    Log::warning("Errores de validación para la actividad #{$index}", ['errors' => $validator->errors()->toArray()]);
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                // Buscar la asignación general correspondiente
                $generalAssignment = GeneralAssignment::where('degrees_id', $activityData['degree'])
                    ->where('section_id', $activityData['section'])
                    ->where('course_id', $activityData['course'])
                    ->first();

                if (!$generalAssignment) {
                    Log::warning('No existe una asignación general para los parámetros seleccionados.', [
                        'degree_id' => $activityData['degree'],
                        'section_id' => $activityData['section'],
                        'course_id' => $activityData['course']
                    ]);
                    continue;
                }

                // Crear la actividad
                $activity = Activity::create([
                    'name' => $activityData['name'],
                    'plucking' => $activityData['plucking'],
                    'date_entity' => $activityData['date_entity'],
                    'bimester' => $activityData['bimester'],
                    'year' => $activityData['year'],
                    'general_assignment_id' => $generalAssignment->id,
                    'state' => '1',
                ]);

                Log::info('Actividad creada correctamente.', [
                    'activity_name' => $activityData['name'],
                    'general_assignment_id' => $generalAssignment->id,
                    'activity_id' => $activity->id,
                ]);

                // Obtener los estudiantes asociados
                $studentAssignments = StudentAssignment::where('general_assignment_id', $generalAssignment->id)->get();
                Log::info("Estudiantes encontrados para asignación general #{$generalAssignment->id}", ['student_count' => $studentAssignments->count()]);

                foreach ($studentAssignments as $studentAssignment) {
                    Ratings::create([
                        'student_id' => $studentAssignment->student_id,
                        'activity_id' => $activity->id,
                        'score_obtained' => 0 // Valor por defecto
                    ]);
                    Log::info('Calificación inicial creada para estudiante.', [
                        'student_id' => $studentAssignment->student_id,
                        'activity_id' => $activity->id,
                    ]);
                }
            }

            return redirect('/activity')->with('message', 'Actividades creadas y calificaciones inicializadas correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear la actividad: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e
            ]);
            return redirect()->back()->with('error', 'Ocurrió un problema al crear las actividades.');
        }
    }



    public function disableActivity($id)
    {
        try {
            $activity = Activity::findOrFail($id);
            $activity->disable();
            return redirect('/activity')->with('message', 'Actividad desactivada exitosamente.');
        } catch (\Exception $e) {
            return redirect('/activity')->with('error', 'Error al desactivar la actividad ');
        }
    }

    public function activeActivity($id)
    {
        try {
            $activity = Activity::findOrFail($id);
            $activity->enable();
            return redirect('/activity')->with('message', 'Actividad activada exitosamente.');
        } catch (\Exception $e) {
            return redirect('/activity')->with('error', 'Error al desactivar la actividad ');
        }
    }

    public function trashActivity(Request $request)
    {
        try {
            $degreeId = $request->query('degree_id');
            $sectionId = $request->query('section_id');
            $courseId = $request->query('course_id');
            $search = $request->query('search');

            // Consulta inicial de actividades
            $activities = Activity::where('state', 0) // Solo actividades activas/inactivas
                ->when($degreeId || $sectionId || $courseId, function ($query) use ($degreeId, $sectionId, $courseId) {
                    // Filtrar por asignación general (general_assignment_id)
                    $query->whereHas('generalAssignment', function ($query) use ($degreeId, $sectionId, $courseId) {
                        $query
                            ->when($degreeId, function ($query) use ($degreeId) {
                                return $query->where('degrees_id', $degreeId);
                            })
                            ->when($sectionId, function ($query) use ($sectionId) {
                                return $query->where('section_id', $sectionId);
                            })
                            ->when($courseId, function ($query) use ($courseId) {
                                return $query->where('course_id', $courseId);
                            });
                    });
                })
                ->when($search, function ($query) use ($search) {
                    // Filtro de búsqueda por nombre
                    return $query->where('name', 'LIKE', "%{$search}%");
                })
                ->paginate(10)
                ->appends([
                    'degree_id' => $degreeId,
                    'section_id' => $sectionId,
                    'course_id' => $courseId,
                    'search' => $search
                ]);

            // Obtener datos para los selectores en la vista
            $degrees = Degree::all();
            $sections = Sections::all();
            $courses = Courses::all();

            // Retornar la vista con los datos necesarios
            return view('activity.trashActivity', [
                'activities' => $activities,
                'degrees' => $degrees,
                'sections' => $sections,
                'courses' => $courses
            ]);
        } catch (\Exception $e) {
            return redirect('/activity')->with('error', 'Ocurrió un problema al listar las actividades.');
        }
    }

    public function generatePDF(Request $request)
    {
        // Estructuramos los datos de los estudiantes
        $studentIds = $request->input('student_ids'); // Array con los IDs de los estudiantes

        // Obtener nombres de estudiantes de la base de datos
        $students = DB::table('tb_student')
            ->whereIn('id', $studentIds)
            ->get(['id', 'first_name', 'second_name', 'first_lastname', 'second_lastname']);

        // Crear un arreglo estructurado para cada estudiante
        $studentsData = [];
        foreach ($students as $index => $student) {
            $studentsData[] = [
                'id' => $student->id,
                'nombre' => trim("{$student->first_name} {$student->second_name} {$student->first_lastname} {$student->second_lastname}"),
                'actividad1' => $request->input('actividad1')[$index] ?? 0,
                'actividad2' => $request->input('actividad2')[$index] ?? 0,
                'actividad3' => $request->input('actividad3')[$index] ?? 0,
                'mejoramiento1' => $request->input('mejoramiento1')[$index] ?? 0,
                'mejoramiento2' => $request->input('mejoramiento2')[$index] ?? 0,
                'mejoramiento3' => $request->input('mejoramiento3')[$index] ?? 0,
                'disciplina' => $request->input('Disciplina')[$index] ?? 0,
                'extracurricular' => $request->input('extracurricular')[$index] ?? 0,
                'examen' => $request->input('examen')[$index] ?? 0,
                'notaFinal' => $request->input('notaFinal')[$index] ?? 0,
            ];
        }

        // Generamos el PDF pasando los datos estructurados
        $pdf = PDF::loadView('pdf.notas', compact('studentsData'));

        // Descargamos el PDF
        return $pdf->download('Reporte_Estudiantes.pdf');
    }

}
