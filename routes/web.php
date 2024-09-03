<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LawController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\logoutController;
use Illuminate\Support\Facades\Route;

// **** RUTA PARA LOGIN ****
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/home', [HomeController::class, 'index']);
Route::get('/pagos', [HomeController::class, 'menu2']);
Route::get('/caja', [HomeController::class, 'menu3']);
Route::get('/reporteria', [HomeController::class, 'menu4']);

Route::get('/logout', [logoutController::class, 'logout']);
