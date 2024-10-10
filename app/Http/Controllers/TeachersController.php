<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class TeachersController extends Controller
{
    public function listTeachers()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'docente');
        })->paginate(10);

        return view('teachers.listTeachers', compact('users')); // Cambia 'user' a 'users'
    }
    public function showEdit($id)
    {
        $user = User::with('roles')->findOrFail($id); // Carga el usuario por id
        $roles = Role::all()->pluck('name', 'id');
        return view('teachers.editTeachers', compact('user', 'roles'));
    }

    public function editTeacher(Request $request, User $user)
    {
        try {
            // Validar entrada
            $data = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'roles' => 'array',
                'roles.*' => 'exists:roles,id'
            ]);

            // Actualizar datos del usuario
            $user->update($data);

            // Sincronizar roles
            if (isset($data['roles'])) {
                // Obtener nombres de roles en lugar de IDs
                $roleNames = Role::whereIn('id', $data['roles'])
                    ->pluck('name')
                    ->toArray();
                $user->syncRoles($roleNames);
            } else {
                $user->syncRoles([]);
            }

            return redirect()->route('/teachers')->with('success', 'Usuario actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar el usuario', ['error' => $e->getMessage()]);
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function disableUser($id)
    {
        $user = User::find($id);
        $user->disable();
        return redirect('/teachers');
    }

    public function activeUser($id)
    {
        $user = User::find($id);
        $user->enable();
        return redirect('/teachers');
    }
}
