<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\degreesController;
use App\Http\Controllers\LawController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\coursesController;
use App\Http\Controllers\sectionsController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\StudentController;
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
    Route::get('/', [degreesController::class, 'listDegrees']);
    Route::post('/new', [degreesController::class, 'createDegrees']);
    Route::post('/delete/{id}', [degreesController::class, 'disableDegrees']);
    Route::post('/edit/{id}', [degreesController::class, 'editDegrees']);
    Route::get('/trash', [degreesController::class, 'trashDegrees']);
    Route::post('/restore/{id}', [degreesController::class, 'activeDegrees']);
});

// ROUTES SECTIONS
Route::prefix('sections')->group(function () {
    Route::get('/', [sectionsController::class, 'listSections']);
    Route::post('/new', [sectionsController::class, 'createSections']);
    Route::post('/delete/{id}', [sectionsController::class, 'disableSections']);
    Route::post('/edit/{id}', [sectionsController::class, 'editSection']);
    Route::get('/trash', [sectionsController::class, 'trashSections']);
    Route::post('/restore/{id}', [sectionsController::class, 'activeSections']);
});


//ROUTES COURSES
Route::prefix('courses')->group(function () {
Route::get('/',[ coursesController::class,'listCourses']);
Route::post('/new',[ coursesController::class,'createCourses']);
Route::post('/delete/{id}', [coursesController::class, 'disableCourses']);
Route::post('/edit/{id}', [coursesController::class, 'editCourses']);
Route::get('/trash', [coursesController::class, 'trashCourses']);
Route::post('/restore/{id}', [coursesController::class, 'activeCourses']);
});


// Rutas para el estudiante
Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'listStudent']);
    Route::get('/new', [StudentController::class, 'showCreateForm']);
    Route::post('/newN', [StudentController::class, 'createStudent']);
    Route::post('/delete/{id}', [StudentController::class, 'disableStudent']);
    Route::post('/restore/{id}', [StudentController::class, 'activeStudent']);
    Route::get('/trash', [StudentController::class, 'trashStudent']);

});


