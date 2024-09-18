<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DegreeRequest;
use App\Http\Requests\CoursesRequest;
use App\Models\Degree;
use App\Models\Sections;
use App\Models\Courses;


class resourcesController extends Controller
{
    public function degrees() {

        return view('resourcesJV.degrees.listDegrees');

    }

    public function createDegrees(DegreeRequest $request){
        $degree = Degree::create($request->validated());
        return redirect('/degrees');
    }

    public function sections() {

        return view('resourcesJV.sections.listSections');

    }

    public function createSections(DegreeRequest $request) {

        $sections = Sections::create($request->validated());
        return redirect('/sections');

    }

    public function courses() {

        return view('resourcesJV.courses.listCourses');

    }

    public function createCourses(CoursesRequest $request) {

        $courses = Courses::create($request->validated());
        return redirect('/courses');

    }
}
