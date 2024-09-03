<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LawController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\logoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// **** RUTA PARA ITEMS ****
Route::resource('laws.articles.items', ItemController::class)
    ->names('items');

// **** RUTA PARA ARTICULOS ****
Route::patch('laws/{law}/articles/{article}/validate_items', [ArticleController::class, 'validate_items'])
    ->name('articles.validate_items');

Route::resource('laws.articles', ArticleController::class)
    ->names('articles');

// **** RUTA PARA LEYES ****
Route::resource('laws', LawController::class)->names('laws');

Route::get('/register', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/home', [HomeController::class, 'index']);
Route::get('/menu2', [HomeController::class, 'index']);
Route::get('/menu3', [HomeController::class, 'menu3']);
Route::get('/menu4', [HomeController::class, 'menu4']);

Route::get('/logout', [logoutController::class, 'logout']);

