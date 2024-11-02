<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Degree;
use App\Models\Student;
use App\Models\Sections;
use Illuminate\Http\Request;
use App\Models\Collaborations;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CollaborationsController extends Controller
{
    public function listCollaborations()
    {
        // Captura el parámetro de búsqueda
        $search = request()->query('search');

        // Inicia la consulta
        $query = Collaborations::where('state', 1);

        // Aplica el filtro de búsqueda si hay un término de búsqueda
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%'); // Reemplaza 'field1', 'field2', etc., con los nombres de columnas donde deseas buscar
            });
        }

        // Obtiene los resultados paginados
        $collaborations = $query->paginate(10);

        // Resto de las variables necesarias para la vista
        $degrees = Degree::all();
        $sections = Sections::all();
        $users = User::all();
        $months = Constants::MONTHS;

        // Retorna la vista con los datos
        return view('collaborations.listCollaborations', [
            'collaborations' => $collaborations,
            'degrees' => $degrees,
            'sections' => $sections,
            'users' => $users,
            'months' => $months
        ]);
    }

    public function createCollaborations(Request $request)
    {
        try {
            $validatedCollaborations = $request->validate([
                'name' => 'required'
            ]);

            $collaborations = Collaborations::create($validatedCollaborations);
            return redirect('/collaborations')->with('message', 'Colaboración creada exitosamente.');
        } catch (\Exception $e) {
            // Registrar el error para análisis posterior
            Log::error('Error al crear la colaboración', [
                'error' => $e->getMessage(),
                'request_data' => $request->all() // Opcional: registrar los datos del request
            ]);

            return redirect('/collaborations')->with('error', 'Ocurrió un problema al crear la colaboración.');
        }
    }


    public function editCollaborations(Request $request, $id)
    {
        try {
            $collaborations = Collaborations::find($id);

            if (!$collaborations) {
                return redirect('/collaborations')->with('error', 'Colaboración no encontrada.');
            }

            $validatedData = $request->validate([
                'name' => 'required|string|max:255'
            ]);

            $collaborations->update($validatedData);

            return redirect('/collaborations')->with('message', 'Colaboración actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect('/collaborations')->with('error', 'Ocurrió un problema al actualizar la colaboración');
        }
    }

    public function disableCollaborations($id)
    {
        try {
            $collaboration = Collaborations::findOrFail($id); // Usar findOrFail para manejar el caso en que no se encuentre la colaboración
            $collaboration->disable();
            return redirect('/collaborations')->with('message', 'Colaboración desactivada exitosamente.');
        } catch (ModelNotFoundException $e) {
            // Registrar el error de que no se encontró la colaboración
            Log::error('Colaboración no encontrada', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            return redirect('/collaborations')->with('error', 'Colaboración no encontrada.');
        } catch (\Exception $e) {
            // Registrar el error para análisis posterior
            Log::error('Error al desactivar la colaboración', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            return redirect('/collaborations')->with('error', 'Ocurrió un problema al desactivar la colaboración.');
        }
    }

    public function activeCollaborations($id)
    {
        try {
            $collaboration = Collaborations::findOrFail($id); // Usar findOrFail para manejar el caso en que no se encuentre la colaboración
            $collaboration->enable();
            return redirect('/collaborations')->with('message', 'Colaboración activada exitosamente.');
        } catch (ModelNotFoundException $e) {
            // Registrar el error de que no se encontró la colaboración
            Log::error('Colaboración no encontrada', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            return redirect('/collaborations')->with('error', 'Colaboración no encontrada.');
        } catch (\Exception $e) {
            // Registrar el error para análisis posterior
            Log::error('Error al activar la colaboración', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            return redirect('/collaborations')->with('error', 'Ocurrió un problema al activar la colaboración.');
        }
    }

    public function trashCollaborations()
    {
        try {
            $collaborations = Collaborations::where('state', 0)->paginate(10);
            $degrees = Degree::all();
            $sections = Sections::all();
            $users = User::all();
            $months = Constants::MONTHS;

            return view('collaborations.trashCollaborations', [
                'collaborations' => $collaborations,
                'degrees' => $degrees,
                'sections' => $sections,
                'users' => $users,
                'months' => $months
            ]);
        } catch (\Exception $e) {
            // Registrar el error para análisis posterior
            Log::error('Error al obtener colaboraciones en estado de basura', [
                'error' => $e->getMessage(),
            ]);
            return redirect('/collaborations')->with('error', 'Ocurrió un problema al obtener las colaboraciones en estado de basura.');
        }
    }

}
