<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function listStudent()
    {
        // $search = request()->query('search');

        // if ($search) {
        //     $degree = Student::where('name', 'LIKE', "%{$search}%")
        //         ->where('state', 1)
        //         ->paginate(10);
        // } else {
        //     $degree = Student::where('state', 1)->paginate(10);
        // }

        // return view('resourcesJV.degrees.listDegrees', ['degree' => $degree]);
        return view('student.listStudent');
    }

    public function showCreateForm()
{
    return view('student.createStudent');
}

    public function createStudent(Request $request)
    {
        return view('student.createStudent');
    }

}
