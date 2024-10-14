<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DegreeRequest;
use App\Http\Requests\CoursesRequest;
use App\Http\Requests\SectionsRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Degree;
use App\Models\Sections;
use App\Models\Courses;
use Symfony\Component\Stopwatch\Section;

class coursesController extends Controller
{
    public function listCourses()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');

            if ($degreeId || $search) {
                $courses = Courses::where('state', 1)
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
                $courses = Courses::where('state', 1)->paginate(10);
            }

            $degrees = Degree::all();

            return view('resourcesJV.courses.listCourses', [
                'courses' => $courses,
                'degrees' => $degrees
            ]);
        } catch (\Exception $e) {
            return redirect('/courses')->with('error', 'Ocurrió un problema.');
        }
    }

    public function createCourses(CoursesRequest $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:courses,name',
                'degree_id' => 'required|exists:degrees,id'
            ]);

            Courses::create($request->validated());

            return redirect('/courses')->with('message', 'Curso creado con éxito.');
        } catch (\Exception $e) {
            return redirect('/courses')->with('error', 'El curso ya existe');
        }
    }

    public function disableCourses($id)
    {
        try {
            $courses = Courses::findOrFail($id);
            $courses->disable();
            return redirect('/courses')->with('message', 'Curso desactivado exitosamente.');
        } catch (\Exception $e) {
            return redirect('/courses')->with('error', 'Error al desactivar el curso: ' . $e->getMessage());
        }
    }

    public function activeCourses($id)
    {
        try {
            $courses = Courses::findOrFail($id);
            $courses->enable();
            return redirect('/courses')->with('message', 'Curso activado exitosamente.');
        } catch (\Exception $e) {
            return redirect('/courses')->with('error', 'Error al activar el curso: ' . $e->getMessage());
        }
    }

    public function trashCourses()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');

            if ($degreeId || $search) {
                $courses = Courses::where('state', 0)
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
                $courses = Courses::where('state', 0)->paginate(10);
            }

            $degrees = Degree::all();

            return view('resourcesJV.courses.trashCourses', [
                'courses' => $courses,
                'degrees' => $degrees
            ]);
        } catch (\Exception $e) {
            return redirect('/courses')->with('error', 'Ocurrió un problema' . $e->getMessage());
        }
    }

    public function editCourses(DegreeRequest $request, $id)
    {
        try {
            $courses = Courses::find($id);

            if (!$courses) {
                return redirect('/courses')->with('error', 'Curso no encontrado.');
            }

            $courses->update($request->validated());

            return redirect('/courses')->with('message', 'Curso actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect('/courses')->with('error', 'Ocurrió un problema al actualizar el curso' . $e->getMessage());
        }
    }
}
