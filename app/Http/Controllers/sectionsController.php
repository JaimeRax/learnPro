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

class sectionsController extends Controller
{
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

}
