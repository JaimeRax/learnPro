<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Degree;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class assignmentController extends Controller
{
    public function listAssignmentStudent()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');

            if ($degreeId || $search) {
                $student = Student::where('state', 1)
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
                $student = Student::where('state', 1)->paginate(10);
            }

            $degrees = Degree::all();

            return view('assignment.listAssignment', [
                'student' => $student,
                'degrees' => $degrees
            ]);
        } catch (\Exception $e) {
            return redirect('/student')->with('error', 'Ocurrió un problema.');
        }
    }

    public function createAssignment(Request $request, $id)
    {
        // Encuentra al estudiante
        $student = Student::find($id);

        if (!$student) {
            return redirect('/student')->with('error', 'Estudiante no encontrado.');
        }

        // Valida los datos del estudiante
        $validatedData = $request->validate([
            'degree_id' => 'nullable',
            'section_id' => 'nullable'
        ]);

        // Actualiza el estudiante con los datos validados
        $student->update($validatedData);

        return redirect('/student')->with('success', 'Estudiante actualizado correctamente.');
    }

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
            if (!$teacher->courses()->where('course_id', $selection['course_id'])
                ->where('section_id', $selection['section_id'])
                ->where('degree_id', $selection['degree_id'])->exists()) {

                Log::info('Asignando curso', ['course_id' => $selection['course_id'], 'teacher_id' => $teachers_id]);
                $teacher->courses()->attach($selection['course_id'], [
                    'section_id' => $selection['section_id'],
                    'degree_id' => $selection['degree_id'],
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
