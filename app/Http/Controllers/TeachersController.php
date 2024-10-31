<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Degree;
use App\Models\Courses;
use App\Models\Sections;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TeachersController extends Controller
{
    public function listCoursesTeacher()
    {
        try {
            $user = Auth::user(); // Obtén el usuario autenticado
            $degreeId = request()->query('degrees_id'); // Captura el parámetro degrees_id de la solicitud
            $search = request()->query('search');

            if ($user && $user->hasRole('docente')) {
                // Verifica si el usuario tiene el rol de "docente"
                $courses = $user
                    ->courses() // Relación con los cursos asignados al usuario
                    ->when($degreeId, function ($query) use ($degreeId) {
                        return $query->where('degrees_id', $degreeId); // Filtra por degree_id si se proporciona
                    })
                    ->when($search, function ($query) use ($search) {
                        return $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->paginate(10)
                    ->appends([
                        'degrees_id' => $degreeId,
                        'search' => $search
                    ]);

                $degrees = Degree::all();
                $sections = Sections::all();

                return view('teachers.myCourses', [
                    'user' => $user,
                    'courses' => $courses,
                    'sections' => $sections,
                    'degrees' => $degrees
                ]);
            }

            return redirect('/teachers/myCourses')->with('error', 'No tiene el rol necesario o no está autenticado.');
        } catch (\Exception $e) {
            return redirect('/teachers/myCourses')->with('error', 'Ocurrió un problema.');
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
