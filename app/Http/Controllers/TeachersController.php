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
    public function ListCoursesTeacher(){

        return view('teachers.myCourses');
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
                'degrees' => $degrees,
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
