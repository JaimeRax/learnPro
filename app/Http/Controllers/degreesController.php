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

class degreesController extends Controller
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

}
