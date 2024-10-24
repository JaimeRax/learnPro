<?php

namespace App\Http\Controllers;

use App\Http\Requests\DegreeRequest;
use App\Models\Degree;
use App\Models\Sections;

class degreesController extends Controller
{
    //FUNCTIONS COURSES

    public function listDegrees()
    {
        $search = request()->query('search');
        $sections = Sections::all();

        if ($search) {
            $degree = Degree::where('name', 'LIKE', "%{$search}%")
                ->where('state', 1)
                ->with('section')
                ->paginate(10);
        } else {
            $degree = Degree::where('state', 1)
                ->with('section')
                ->paginate(10);
        }

        return view('resourcesJV.degrees.listDegrees', [
            'degree' => $degree,
            'sections' => $sections
        ]);
    }


    public function createDegrees(DegreeRequest $request)
    {
        try {
            $degree = Degree::create($request->validated());
            return redirect('/degrees')->with('message', 'Grado creado exitosamente.');
        } catch (\Exception $e) {
            return redirect('/degrees')->with('error', 'Ocurrió un problema al crear el grado ');
        }
    }
    public function disableDegrees($id)
    {
        try {
            $degree = Degree::findOrFail($id);
            $degree->disable();
            return redirect('/degrees')->with('message', 'Grado desactivado exitosamente.');
        } catch (\Exception $e) {
            return redirect('/degrees')->with('error', 'Error al desactivar el grado');
        }
    }

    public function activeDegrees($id)
    {
        try {
            $degree = Degree::findOrFail($id);
            $degree->enable();
            return redirect('/degrees')->with('message', 'Grado activado exitosamente.');
        } catch (\Exception $e) {
            return redirect('/degrees')->with('error', 'Error al activar el grado ');
        }
    }

    public function trashDegrees()
    {
        try {
            $search = request()->query('search');

            if ($search) {
                $degree = Degree::where('name', 'LIKE', "%{$search}%")
                    ->where('state', 0)
                    ->paginate(10);
            } else {
                $degree = Degree::where('state', 0)->paginate(10);
            }

            return view('resourcesJV.degrees.trashDegrees', ['degree' => $degree]);
        } catch (\Exception $e) {
            return redirect('/degrees')->with('error', 'Ocurrió un problema al obtener los grados');
        }
    }

    public function editDegrees(DegreeRequest $request, $id)
    {
        try {
            $degree = Degree::findOrFail($id);
            $degree->update($request->validated());

            return redirect('/degrees')->with('message', 'Grado actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect('/degrees')->with('error', 'Ocurrió un problema al actualizar el grado ');
        }
    }
}
