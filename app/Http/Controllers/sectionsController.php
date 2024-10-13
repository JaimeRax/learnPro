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
        try {
            $sections = Sections::create($request->validated());
            return redirect('/sections')->with('message', 'Sección creada exitosamente');
        } catch (\Exception $e) {
            return redirect('/sections')->with('error', 'Ocurrió un problema al crear la sección ' . $e->getMessage());
        }
    }

    public function disableSections($id)
    {
        try {
            $sections = Sections::findOrFail($id);
            $sections->disable();
            return redirect('/sections')->with('message', 'Sección desactivada exitosamente.');
        } catch (\Exception $e) {
            return redirect('/sections')->with('error', 'Error al desactivar la sección ' . $e->getMessage());
        }
    }

    public function activeSections($id)
    {
        try {
            $sections = Sections::findOrFail($id);
            $sections->enable();
            return redirect('/sections')->with('message', 'Sección activada exitosamente.');
        } catch (\Exception $e) {
            return redirect('/sections')->with('error', 'Error al activar la sección ' . $e->getMessage());
        }
    }

    public function trashSections()
    {
        try {
            $search = request()->query('search');

            if ($search) {
                $sections = Sections::where('name', 'LIKE', "%{$search}%")
                    ->where('state', 0)
                    ->paginate(10);
            } else {
                $sections = Sections::where('state', 0)->paginate(10);
            }

            return view('resourcesJV.sections.trashSections', ['sections' => $sections]);
        } catch (\Exception $e) {
            return redirect('/sections')->with('error', 'Ocurrió un problema al obtener las secciones ' . $e->getMessage());
        }
    }

    public function editSection(SectionsRequest $request, $id)
    {
        $section = Sections::find($id);

        if (!$section) {
            return redirect('/sections')->with('error', 'Grado no encontrado.');
        }

        $section->update($request->validated());

        return redirect('/sections')->with('message', 'Grado actualizado correctamente.');
    }
}
