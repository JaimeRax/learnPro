<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home.index');
    }

    public function menu2(){
        return view('home.menu2');
    }

    public function menu3(){
        return view('home.menu3');
    }


    public function menu4(){
        return view('home.menu4');
    }
}
