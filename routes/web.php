<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\resourcesController;
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

//ROUTES REGISTER
Route::get('/register', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'register']);


//ROUTES LOGIN-LOGOUT
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [logoutController::class, 'logout']);


//ROUTES MENU
Route::get('/home', [HomeController::class, 'index']);
Route::get('/pagos', [HomeController::class, 'menu2']);
Route::get('/caja', [HomeController::class, 'menu3']);
Route::get('/reporteria', [HomeController::class, 'menu4']);


// ROUTES DEGRES
Route::prefix('degrees')->group(function () {
    Route::get('/', [resourcesController::class, 'listDegrees']);
    Route::post('/new', [resourcesController::class, 'createDegrees']);
    Route::post('/delete/{id}', [resourcesController::class, 'disableDegrees']);
    Route::post('/edit/{id}', [resourcesController::class, 'editDegrees']);
    Route::get('/trash', [resourcesController::class, 'trashDegrees']);
    Route::post('/restore/{id}', [resourcesController::class, 'activeDegrees']);
});

// ROUTES SECTIONS
Route::prefix('sections')->group(function () {
    Route::get('/', [resourcesController::class, 'listSections']);
    Route::post('/new', [resourcesController::class, 'createSections']);
    Route::post('/delete/{id}', [resourcesController::class, 'disableSections']);
    Route::post('/edit/{id}', [resourcesController::class, 'editSection']);
    Route::get('/trash', [resourcesController::class, 'trashSections']);
    Route::post('/restore/{id}', [resourcesController::class, 'activeSections']);
});


//ROUTES COURSES
Route::prefix('courses')->group(function () {
Route::get('/',[ resourcesController::class,'listCourses']);
Route::post('/new',[ resourcesController::class,'createCourses']);
Route::post('/delete/{id}', [resourcesController::class, 'disableCourses']);
Route::post('/edit/{id}', [resourcesController::class, 'editCourses']);
Route::get('/trash', [resourcesController::class, 'trashCourses']);
Route::post('/restore/{id}', [resourcesController::class, 'activeCourses']);
});


