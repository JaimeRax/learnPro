<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Degree;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class assignmentController extends Controller
{
    public function listAssignment()
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
        $request->validate([
            'teachers_id' => 'required',
            'course_id' => 'required',
            'section_id' => 'required',
            'degree_id' => 'required',
        ]);

        try {
            $teachers_id = $request->input('teachers_id');
            $course_ids = $request->input('course_id');
            $section_ids = $request->input('section_id');
            $degree_ids = $request->input('degree_id');

            $teacher = User::findOrFail($teachers_id);

            foreach ($course_ids as $key => $course_id) {
                $teacher->courses()->attach($course_id, [
                    'section_id' => $section_ids[$key],
                    'degree_id' => $degree_ids[$key],
                ]);
            }

            return redirect('/users')->with('success', 'Cursos asignados correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al asignar cursos', [
                'teachers_id' => $teachers_id,
                'course_ids' => $course_ids,
                'section_ids' => $section_ids,
                'degree_ids' => $degree_ids,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return redirect('/users')->with('error', 'Ocurrió un error al asignar los cursos. Por favor, inténtelo más tarde.');
        }
    }
}
