<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionsRequest;
use App\Models\Sections;
use Illuminate\Support\Facades\Log;

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

    public function createSections(SectionsRequest $request)
    {
        try {
            $sections = Sections::create($request->validated());
            return redirect('/sections')->with('message', 'Sección creada exitosamente');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect('/sections')->with('error', 'Ocurrió un problema al crear la sección ');
        }
    }

    public function disableSections($id)
    {
        try {
            $sections = Sections::findOrFail($id);
            $sections->disable();
            return redirect('/sections')->with('message', 'Sección desactivada exitosamente.');
        } catch (\Exception $e) {
            return redirect('/sections')->with('error', 'Error al desactivar la sección ');
        }
    }

    public function activeSections($id)
    {
        try {
            $sections = Sections::findOrFail($id);
            $sections->enable();
            return redirect('/sections')->with('message', 'Sección activada exitosamente.');
        } catch (\Exception $e) {
            return redirect('/sections')->with('error', 'Error al activar la sección ');
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
            return redirect('/sections')->with('error', 'Ocurrió un problema al obtener las secciones ');
        }
    }

    public function editSection(SectionsRequest $request, $id)
    {
        $section = Sections::find($id);

        if (!$section) {
            return redirect('/sections')->with('error', 'Sección no encontrado.');
        }

        $section->update($request->validated());

        return redirect('/sections')->with('message', 'Sección actualizado correctamente.');
    }
}
