<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\coursesController;
use App\Http\Controllers\degreesController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\paymentsController;
use App\Http\Controllers\sectionsController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\assignmentController;

// **** RUTA PARA LOGIN ****
Route::get('/', function () {
    return redirect()->route('login');
});

//ROUTES REGISTER
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'listUsers'])->name('users.index');

Route::get('/register', [UserController::class, 'show']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/viewForm', [UserController::class, 'showCreateForm']);
Route::post('/newUser', [UserController::class, 'createUser']);
Route::get('/showForm/{id}', [UserController::class, 'showEdit']);
Route::post('/delete/{id}', [UserController::class, 'disableUser']);
Route::post('/edit/{user}', [UserController::class, 'editUsers']);
Route::get('/trash', [UserController::class, 'trashUsers']);
Route::post('/restore/{id}', [UserController::class, 'activeUser']);
});



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
    Route::get('/', [ coursesController::class,'listCourses']);
    Route::post('/new', [ coursesController::class,'createCourses']);
    Route::post('/delete/{id}', [coursesController::class, 'disableCourses']);
    Route::post('/edit/{id}', [coursesController::class, 'editCourses']);
    Route::get('/trash', [coursesController::class, 'trashCourses']);
    Route::post('/restore/{id}', [coursesController::class, 'activeCourses']);
});


// ROUTES STUDENT
Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'listStudent']);
    Route::get('/viewForm', [StudentController::class, 'showCreateForm']);
    Route::post('/newStudent', [StudentController::class, 'createStudent']);
    Route::post('/delete/{id}', [StudentController::class, 'disableStudent']);
    Route::get('/edit/{id}', [StudentController::class, 'editStudent']);
    Route::post('/restore/{id}', [StudentController::class, 'activeStudent']);
    Route::get('/trash', [StudentController::class, 'trashStudent']);
});

//ROUTES PAYMENTS
Route::prefix('payments')->group(function () {
    Route::get('/', [paymentsController::class, 'listPayments']);
    Route::get('/new/{id}', [paymentsController::class, 'ShowcreatePayments']);
    Route::post('/newForm/{id}', [paymentsController::class, 'createPayments'])->name('payments.list');


});

//ROUTES ASSIGNMENTO
Route::prefix('assignment')->group(function () {
    Route::get('/', [assignmentController::class, 'listAssignment']);
    Route::get('/form', [ assignmentController::class,'ShowcreateAssignment']);
});

// Routes to Reports
Route::prefix('report')->group(function () {
    // TODO: change controller
    Route::get('/ticket', [StudentController::class, 'paymentTicket']);
});

// ROUTES TEACHERS
Route::prefix('teachers')->group(function () {
    Route::get('/', [TeachersController::class, 'listTeachers']);
    Route::get('/showForm/{id}', [TeachersController::class, 'showEdit']);
    Route::post('/edit/{user}', [TeachersController::class, 'editTeacher']);

});

// ROUTES RATINGS
Route::prefix('ratings')->group(function () {
    Route::get('/', [RatingsController::class, 'listRatings']);

});
