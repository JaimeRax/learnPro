<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Degree;
use App\Models\Student;
use App\Models\Sections;
use Illuminate\Http\Request;
use App\Models\Collaborations;

class CollaborationsController extends Controller
{
    public function listCollaborations()
    {
        $collaborations = Collaborations::where('state', 1)
            // ->with(['degree', 'section', 'payments' => function ($query) {
            //     $query->where('year', date('Y'));
            // }])
            ->paginate(10);
        // }

        $degrees = Degree::all();
        $sections = Sections::all();
        $users = User::all();
        $months = Constants::MONTHS;

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
            return redirect('/collaborations')->with('message', 'Colaboraciòn creada exitosamente.');
        } catch (\Exception $e) {
            return redirect('/collaborations')->with('error', 'Ocurrió un problema al crear la Colaboraciòn ');
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
        $collaborations = Collaborations::find($id);
        $collaborations->disable();
        return redirect('/collaborations');
    }

    public function activeCollaborations($id)
    {
        $collaborations = Collaborations::find($id);
        $collaborations->enable();
        return redirect('/collaborations');
    }

    public function trashCollaborations()
    {
        $collaborations = Collaborations::where('state', 0)
            // ->with(['degree', 'section', 'payments' => function ($query) {
            //     $query->where('year', date('Y'));
            // }])
            ->paginate(10);
        // }

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
    }

}
