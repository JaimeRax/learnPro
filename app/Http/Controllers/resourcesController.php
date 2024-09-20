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

class resourcesController extends Controller
{
    //FUNCTIONS COURSES

    public function listDegrees()
    {
        $search = request()->query('search');

        if ($search) {
            $degree = Degree::where('name', 'LIKE', "%{$search}%")
                ->where('state', 1)
                ->paginate(10);
        } else {
            $degree = Degree::where('state', 1)->paginate(10);
        }

        return view('resourcesJV.degrees.listDegrees', ['degree' => $degree]);
    }

    public function createDegrees(DegreeRequest $request)
    {
        $degree = Degree::create($request->validated());
        return redirect('/degrees');
    }

    public function disableDegrees($id)
    {
        $degree = Degree::find($id);
        $degree->disable();
        return redirect('/degrees');
    }

    public function activeDegrees($id)
    {
        $degree = Degree::find($id);
        $degree->enable();
        return redirect('/degrees');
    }

    public function trashDegrees()
    {
        $search = request()->query('search');

        if ($search) {
            $degree = Degree::where('name', 'LIKE', "%{$search}%")
                ->where('state', 0)
                ->paginate(10);
        } else {
            $degree = Degree::where('state', 0)->paginate(10);
        }

        return view('resourcesJV.degrees.trashDegrees', ['degree' => $degree]);
    }

    public function editDegrees(DegreeRequest $request, $id)
    {
        $degree = Degree::find($id);

        if (!$degree) {
            return redirect('/degrees')->with('error', 'Grado no encontrado.');
        }

        $degree->update($request->validated());

        return redirect('/degrees')->with('success', 'Grado actualizado correctamente.');
    }




    //FUNCTIONS SECTIONS

    public function listSections()
    {
        $search = request()->query('search');

        if ($search) {
            $sections = Sections::where('name', 'LIKE', "%{$search}%")
                ->where('state', 1)
                ->paginate(10);
        } else {
            $sections = Sections::where('state', 1)->paginate(10);
        }

        return view('resourcesJV.sections.listSections', ['sections' => $sections]);
    }

    public function createSections(DegreeRequest $request)
    {
        $sections = Sections::create($request->validated());
        return redirect('/sections');
    }

    public function disableSections($id)
    {
        $sections = Sections::find($id);
        $sections->disable();
        return redirect('/sections');
    }

    public function activeSections($id)
    {
        $sections = Sections::find($id);
        $sections->enable();
        return redirect('/sections');
    }

    public function trashSections()
    {
        $search = request()->query('search');

        if ($search) {
            $sections = Sections::where('name', 'LIKE', "%{$search}%")
                ->where('state', 0)
                ->paginate(10);
        } else {
            $sections = Sections::where('state', 0)->paginate(10);
        }

        return view('resourcesJV.sections.trashSections', ['sections' => $sections]);
    }

    public function editSection(SectionsRequest $request, $id)
    {
        $section = Sections::find($id);

        if (!$section) {
            return redirect('/sections')->with('error', 'Grado no encontrado.');
        }

        $section->update($request->validated());

        return redirect('/sections')->with('success', 'Grado actualizado correctamente.');
    }





    //FUNCTIONS COURSES

    public function listCourses()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');

            if ($degreeId || $search) {
                $courses = Courses::where('state', 1)
                ->when($degreeId, function($query) use ($degreeId) {
                    return $query->where('degree_id', $degreeId);
                })
                ->when($search, function($query) use ($search) {
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
                'degrees' => $degrees,
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
        $courses = Courses::find($id);
        $courses->disable();
        return redirect('/courses');
    }

    public function activeCourses($id)
    {
        $courses = Courses::find($id);
        $courses->enable();
        return redirect('/courses');
    }

    public function trashCourses()
    {
        try {
            $degreeId = request()->query('degree_id');
            $search = request()->query('search');

            if ($degreeId || $search) {
                $courses = Courses::where('state', 0)
                ->when($degreeId, function($query) use ($degreeId) {
                    return $query->where('degree_id', $degreeId);
                })
                ->when($search, function($query) use ($search) {
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
                'degrees' => $degrees,
            ]);

        } catch (\Exception $e) {
            return redirect('/courses')->with('error', 'Ocurrió un problema.');
        }


    }

    public function editCourses(DegreeRequest $request, $id)
    {
        $courses = Courses::find($id);

        if (!$courses) {
            return redirect('/courses')->with('error', 'Grado no encontrado.');
        }

        $courses->update($request->validated());

        return redirect('/courses')->with('success', 'Grado actualizado correctamente.');
    }
}
