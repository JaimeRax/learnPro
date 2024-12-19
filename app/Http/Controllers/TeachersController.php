<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Degree;
use App\Models\Courses;
use App\Models\Sections;
use Illuminate\Http\Request;
use App\Models\GeneralAssignment;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TeachersController extends Controller
{
    public function listCoursesTeacher(Request $request)
    {
        try {
            $user = Auth::user(); // Usuario autenticado

            // Obtener el grado seleccionado (si existe)
            $selectedDegreeId = $request->input('degrees_id');

            // Obtener todos los registros de 'tb_general_assignment' donde 'teachers_id' sea el ID del usuario
            $assignmentsQuery = GeneralAssignment::where('teachers_id', $user->id);

            // Filtrar por grado si se selecciona uno en el formulario
            if ($selectedDegreeId) {
                $assignmentsQuery->where('degrees_id', $selectedDegreeId);
            }

            $assignments = $assignmentsQuery->get();

            // Obtener todos los cursos asignados, incluyendo sus grados y secciones desde las relaciones
            $courses = $assignments->map(function ($assignment) {
                $course = Courses::with(['degree', 'sections'])
                    ->where('id', $assignment->course_id)
                    ->first();

                return [
                    'course' => $course,
                    'degree' => Degree::find($assignment->degrees_id),
                    'section' => Sections::find($assignment->section_id)
                ];
            });

            // Obtener todos los grados para el select del formulario
            $degrees = Degree::all();

            return view('teachers.myCourses', [
                'user' => $user,
                'courses' => $courses,
                'degrees' => $degrees, // Pasar la lista de grados a la vista
                'selectedDegreeId' => $selectedDegreeId, // Pasar el grado seleccionado
            ]);
        } catch (\Exception $e) {
            return redirect('/teachers/myCourses')->with('error', 'Ocurrió un problema al cargar los cursos.');
        }
    }


    public function listTeachers()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');
            $roleDocente = 'docente';

            if ($degreeId || $search) {
                $users = User::where('state', 1)
                    ->when($degreeId, function ($query) use ($degreeId) {
                        return $query->where('degree_id', $degreeId);
                    })
                    ->when($search, function ($query) use ($search) {
                        return $query->where('first_name', 'LIKE', "%{$search}%");
                    })
                    ->whereHas('roles', function ($query) use ($roleDocente) {
                        $query->where('name', $roleDocente);
                    })
                    ->paginate(10)
                    ->appends([
                        'degree_id' => $degreeId,
                        'search' => $search
                    ]);
            } else {
                $users = User::where('state', 1)
                    ->whereHas('roles', function ($query) use ($roleDocente) {
                        $query->where('name', $roleDocente);
                    })
                    ->paginate(10);
            }

            $degrees = Degree::all();
            $courses = Courses::all();
            $sections = Sections::all();

            return view('teachers.listTeachers', [
                'users' => $users,
                'courses' => $courses,
                'sections' => $sections,
                'degrees' => $degrees
            ]);
        } catch (\Exception $e) {
            return redirect('/teachers')->with('error', 'Ocurrió un problema.');
        }
    }

    public function disableUser($id)
    {
        $user = User::find($id);
        $user->disable();
        return redirect('/teachers');
    }

    public function activeUser($id)
    {
        $user = User::find($id);
        $user->enable();
        return redirect('/teachers');
    }
}
