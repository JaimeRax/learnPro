<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Degree;
use App\Models\Courses;
use App\Models\Student;
use App\Models\Sections;
use Illuminate\Http\Request;
use App\Models\GeneralAssignment;
use App\Models\StudentAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class assignmentController extends Controller
{

//   LISTAR ESTUDIANTES PARA ASGINAR

    public function listAssignmentStudent()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');

            // Contar la cantidad de estudiantes por género
            $genderCounts = Student::where('state', 0)
                ->select('gender', DB::raw('count(*) as count'))
                ->groupBy('gender')
                ->pluck('count', 'gender');

            if ($degreeId || $search) {
                $students = Student::where('state', 0)
                    ->when($degreeId, function ($query) use ($degreeId) {
                        return $query->where('degree_id', $degreeId);
                    })
                    ->when($search, function ($query) use ($search) {
                        return $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->paginate(10)
                    ->appends([
                        'degree_id' => $degreeId,
                        'search' => $search
                    ]);
            } else {
                $students = Student::where('state', 0)->paginate(10);
            }

            $degrees = Degree::all();
            $sections = Sections::all();
            $courses = Courses::all();

            return view('assignment.listAssignmentStudent', [
                'students' => $students,
                'degrees' => $degrees,
                'sections' => $sections,
                'courses' => $courses,
                'genderCounts' => $genderCounts // Pasamos los conteos de género a la vista
            ]);
        } catch (\Exception $e) {
            return redirect('/student')->with('error', 'Ocurrió un problema.');
        }
    }

    public function getGenderCounts(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'degree_id' => 'required|integer|exists:tb_student_assignment,degrees_id',
            'section_id' => 'required|integer|exists:tb_student_assignment,section_id',
        ]);

        // Obtener el ID del grado y sección de la solicitud
        $degreeId = $request->input('degree_id');
        $sectionId = $request->input('section_id');

        // Realizar la consulta para contar los estudiantes por género
        $results = StudentAssignment::select(
                'tb_student.gender',
                DB::raw('COUNT(DISTINCT tb_student_assignment.student_id) AS total_estudiantes')
            )
            ->join('tb_student', 'tb_student_assignment.student_id', '=', 'tb_student.id')
            ->where('tb_student.state', 1)
            ->whereIn('tb_student.gender', ['MASCULINO', 'FEMENINO'])
            ->where('tb_student_assignment.degrees_id', $degreeId)
            ->where('tb_student_assignment.section_id', $sectionId)
            ->groupBy('tb_student.gender')
            ->orderBy('tb_student.gender')
            ->get();

        // Devolver los resultados como una respuesta JSON
        return response()->json($results);
    }




    //CREAR ASIGNACION PARA ESTUDIANTES

    public function createAssignment(Request $request, $id)
    {
        // Encuentra al estudiante por ID
        $student = Student::findOrFail($id);
        Log::info('Estudiante encontrado:', ['student_id' => $student->id]);

        $student->state = 1;
        $student->save();
        Log::info('Estado del estudiante actualizado a 1.', ['student_id' => $student->id]);


        // Busca los registros que coinciden en tb_general_assignment
        $generalAssignments = GeneralAssignment::where('degrees_id', $request->degrees_id)
            ->where('section_id', $request->section_id)
            ->get();

        // Verifica si se encontraron coincidencias
        if ($generalAssignments->isEmpty()) {
            Log::warning('No se encontraron coincidencias en tb_general_assignment:', [
                'degrees_id' => $request->degrees_id,
                'section_id' => $request->section_id
            ]);
            return redirect()->back()->with('error', 'No se encontraron coincidencias en las asignaciones generales.');
        }

        // Inserta cada coincidencia en la tabla de asignaciones de estudiantes
        foreach ($generalAssignments as $generalAssignment) {
            try {
                // Crea una nueva entrada en la tabla de asignaciones de estudiantes
                StudentAssignment::create([
                    'general_assignment_id' => $generalAssignment->id, // Guarda el ID encontrado
                    'year' => $request->year ?? date('Y'), // Asigna el año actual si no se proporciona
                    'student_id' => $student->id, // Asigna el ID del estudiante
                    'degrees_id' => $request->degrees_id, // Agregar degrees_id
                    'section_id' => $request->section_id // Agregar section_id
                ]);
                Log::info('Asignación creada:', [
                    'general_assignment_id' => $generalAssignment->id,
                    'student_id' => $student->id,
                    'year' => $request->year ?? date('Y'),
                    'degrees_id' => $request->degrees_id,
                    'section_id' => $request->section_id // Log de section_id
                ]);
            } catch (\Exception $e) {
                Log::error('Error al crear la asignación:', [
                    'general_assignment_id' => $generalAssignment->id,
                    'student_id' => $student->id,
                    'error_message' => $e->getMessage()
                ]);
                return redirect()->back()->with('error', 'Error al crear la asignación.');
            }
        }

        return redirect('/student')->with('success', 'Asignaciones creadas correctamente.');
    }




    //VISTA PARA ASIGNAR CURSOS A DOCENTES

    public function ShowcreateAssignment(Request $request, $id)
    {
        // Buscar el usuario por ID
        $user = User::find($id);
        $degrees = Degree::all();
        $courses = Courses::all();
        $sections = Sections::all();

        // Validar si el usuario existe
        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        // Pasar el usuario a la vista
        return view('assignment.assignmentCourses-Teacher', [
            'user' => $user, // Cambiado a 'user' para mayor claridad
            'courses' => $courses,
            'sections' => $sections,
            'degrees' => $degrees
        ]);
    }



    // ASIGNAR CURSOS A DOCENTES

    public function newTeacherCourse(Request $request)
    {
        try {
            // Log de entrada
            Log::info('newTeacherCourse llamado', ['request' => $request->all()]);

            $teachers_id = $request->input('teachers_id');
            $selections = $request->input('selections');

            // Asegúrate de que los datos lleguen correctamente al controlador
            if (empty($teachers_id) || empty($selections)) {
                Log::warning('Datos faltantes', ['teachers_id' => $teachers_id, 'selections' => $selections]);
                return response()->json(['success' => false, 'message' => 'Datos faltantes'], 400);
            }

            $teacher = User::findOrFail($teachers_id);
            Log::info('Profesor encontrado', ['teacher_id' => $teachers_id]);

            foreach ($selections as $selection) {
                Log::info('Procesando selección', ['selection' => $selection]);
                // Verificar si ya está asignado
                if (
                    !$teacher
                        ->courses()
                        ->where('course_id', $selection['course_id'])
                        ->where('section_id', $selection['section_id'])
                        ->where('degrees_id', $selection['degrees_id'])
                        ->exists()
                ) {
                    Log::info('Asignando curso', ['course_id' => $selection['course_id'], 'teacher_id' => $teachers_id]);
                    $teacher->courses()->attach($selection['course_id'], [
                        'section_id' => $selection['section_id'],
                        'degrees_id' => $selection['degrees_id']
                    ]);
                } else {
                    Log::info('Curso ya asignado', ['course_id' => $selection['course_id'], 'teacher_id' => $teachers_id]);
                }
            }

            // Respuesta JSON exitosa
            Log::info('Cursos asignados correctamente', ['teacher_id' => $teachers_id]);
            return response()->json(['success' => true, 'message' => 'Cursos asignados correctamente.']);
        } catch (\Exception $e) {
            // Log del error
            Log::error('Error al asignar cursos', ['error' => $e->getMessage()]);
            // Manejar cualquier error y devolver un mensaje de error JSON
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
