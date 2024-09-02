<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use lluminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use PhpParser\Node\Expr\FuncCall;

class RegisterController extends Controller
{
    public function show(){
        if(Auth::check()){
            return redirect('/home');
        }
        return view('auth.register');
    }

    public function register(RegisterRequest $request){
        $user = User::create($request->validated());
        return redirect('/login');
    }


}
