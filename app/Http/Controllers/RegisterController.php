<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use lluminate\Http\RedirectResponse;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function show(){
        if(Auth::check()){
            return redirect('/home');
        }

        $roles = Role::all()->pluck('name','id')->toArray(); // Convertir a array antes de pasar a la vista
        return view('auth.register' , compact('roles'));
    }


    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create($request->validated());

            $roles = $request->input('roles', []);
            if (!is_array($roles)) {
                $roles = [$roles];
            }

            $roleNames = Role::whereIn('id', $roles)->pluck('name')->toArray();
            Log::info('Roles a sincronizar:', ['roles' => $roleNames]);

            $user->syncRoles($roleNames);
            Log::info('Roles sincronizados para el usuario:', ['user_id' => $user->id]);

            return redirect('/login')->with('success', 'Usuario creado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al registrar el usuario: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Hubo un problema al crear el usuario. Inténtalo nuevamente.']);
        }
    }


}
