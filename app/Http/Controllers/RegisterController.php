<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use lluminate\Http\RedirectResponse;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function show(){
        if(Auth::check()){
            return redirect('/home');
        }

        $roles = Role::all()->pluck('name','id')->toArray(); // Convertir a array antes de pasar a la vista
        return view('auth.register' , compact('roles'));
    }


    public function register(RegisterRequest $request){
        $user = User::create($request->validated());
        $roles = $request->input('roles', []);
        $user->syncRoles($roles);
        return redirect('/login', $user->id)->with('success', 'Usuario creado correctamente');
    }


}
