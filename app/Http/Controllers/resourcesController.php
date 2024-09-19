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
    public function listDegrees()
    {
        $degree = DB::table('degrees')->where('state', 1)->get();
        return view('resourcesJV.degrees.listDegrees', ['degree' => $degree]);
    }

    public function createDegrees(DegreeRequest $request){
        $degree = Degree::create($request->validated());
        return redirect('/degrees');
    }

    public function disableDegrees($id)
    {
            $degree = Degree::find($id);
            $degree->desactivar();
            return redirect('/degrees');
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



    public function listSections() {

        $sections = DB::table('sections')->where('state', 1)->get();
        return view('resourcesJV.sections.listSections',['sections'=>$sections]);

    }

    public function createSections(DegreeRequest $request) {

        $sections = Sections::create($request->validated());
        return redirect('/sections');

    }

    public function disableSections($id)
    {
            $sections = Sections::find($id);
            $sections->desactivar();
            return redirect('/sections');
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

    public function listCourses() {

        $courses = DB::table('courses')->where('state', 1)->get();
        return view('resourcesJV.courses.listCourses',['courses'=>$courses]);

    }

    public function createCourses(CoursesRequest $request) {

        $courses = Courses::create($request->validated());
        return redirect('/courses');

    }

    public function disableCourses($id)
    {
            $courses = Courses::find($id);
            $courses->desactivar();
            return redirect('/courses');
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
