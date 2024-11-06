<?php

use App\Http\Controllers\ActivityController;
use App\Models\Collaborations;
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
use App\Http\Controllers\CollaborationsController;
use App\Http\Controllers\ReportController;

// **** RUTA PARA LOGIN ****
Route::get('/', function () {
    return redirect()->route('login');
});

//ROUTES REGISTER
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'listUsers'])->name('users.index');

    Route::get('/register', [UserController::class, 'show']);
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/viewForm', [UserController::class, 'showCreateForm'])->middleware('can:admin');
    Route::post('/newUser', [UserController::class, 'createUser'])->middleware('can:admin');
    Route::get('/showForm/{id}', [UserController::class, 'showEdit'])->middleware('can:admin');
    Route::post('/delete/{id}', [UserController::class, 'disableUser'])->middleware('can:admin');
    Route::post('/edit/{user}', [UserController::class, 'editUsers'])->middleware('can:admin');
    Route::get('/trash', [UserController::class, 'trashUsers'])->middleware('can:admin');
    Route::post('/restore/{id}', [UserController::class, 'activeUser'])->middleware('can:admin');
});


//ROUTES LOGIN-LOGOUT
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [logoutController::class, 'logout']);


//ROUTES MENU
Route::get('/home', [HomeController::class, 'index']);
Route::get('/pagos', [HomeController::class, 'menu2'])->middleware('can:admin');
Route::get('/caja', [HomeController::class, 'menu3'])->middleware('can:admin');
Route::get('/reporteria', [HomeController::class, 'menu4']);


// ROUTES DEGRES
Route::prefix('degrees')->group(function () {
    Route::get('/', [degreesController::class, 'listDegrees'])->middleware('can:admin');
    Route::post('/new', [degreesController::class, 'createDegrees'])->middleware('can:admin');
    Route::post('/delete/{id}', [degreesController::class, 'disableDegrees'])->middleware('can:admin');
    Route::post('/edit/{id}', [degreesController::class, 'editDegrees'])->middleware('can:admin');
    Route::get('/trash', [degreesController::class, 'trashDegrees'])->middleware('can:admin');
    Route::post('/restore/{id}', [degreesController::class, 'activeDegrees'])->middleware('can:admin');
});

// ROUTES SECTIONS
Route::prefix('sections')->group(function () {
    Route::get('/', [sectionsController::class, 'listSections'])->middleware('can:admin');
    Route::post('/new', [sectionsController::class, 'createSections'])->middleware('can:admin');
    Route::post('/delete/{id}', [sectionsController::class, 'disableSections'])->middleware('can:admin');
    Route::post('/edit/{id}', [sectionsController::class, 'editSection'])->middleware('can:admin');
    Route::get('/trash', [sectionsController::class, 'trashSections'])->middleware('can:admin');
    Route::post('/restore/{id}', [sectionsController::class, 'activeSections'])->middleware('can:admin');
});


//ROUTES COURSES
Route::prefix('courses')->group(function () {
    Route::get('/', [ coursesController::class,'listCourses'])->middleware('can:admin');
    Route::post('/new', [ coursesController::class,'createCourses'])->middleware('can:admin');
    Route::post('/delete/{id}', [coursesController::class, 'disableCourses'])->middleware('can:admin');
    Route::post('/edit/{id}', [coursesController::class, 'editCourses'])->middleware('can:admin');
    Route::get('/trash', [coursesController::class, 'trashCourses'])->middleware('can:admin');
    Route::post('/restore/{id}', [coursesController::class, 'activeCourses'])->middleware('can:admin');
});


// ROUTES STUDENT
Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'listStudent'])->middleware('can:admin');
    Route::get('/viewForm', [StudentController::class, 'showCreateForm'])->middleware('can:admin');
    Route::post('/newStudent', [StudentController::class, 'createStudent'])->middleware('can:admin');
    Route::post('/delete/{id}', [StudentController::class, 'disableStudent'])->middleware('can:admin');
    Route::post('/edit/{id}', [StudentController::class, 'editStudent'])->middleware('can:admin');
    Route::get('/formEdit/{id}', [StudentController::class, 'formEditStudent'])->middleware('can:admin');
    Route::post('/restore/{id}', [StudentController::class, 'activeStudent'])->middleware('can:admin');
    Route::get('/trash', [StudentController::class, 'trashStudent'])->middleware('can:admin');
});

//ROUTES PAYMENTS
Route::prefix('payments')->group(function () {
    Route::get('/', [paymentsController::class, 'listPayments'])->middleware('can:admin');
    Route::get('/new/{id}', [paymentsController::class, 'ShowcreatePayments'])->middleware('can:admin');
    Route::post('/newForm/{id}', [paymentsController::class, 'createPayments'])->middleware('can:admin')->name('payments.list');
    Route::get('/listPaymentStudent/{id}', [paymentsController::class, 'listPaymentStudent'])->middleware('can:admin')->name('payments.listPaymentStudent');
    Route::post('/delete/{id}', [PaymentsController::class, 'destroy'])->middleware('can:admin');
});

//ROUTES ASSIGNMENTO
Route::prefix('assignment')->group(function () {
    Route::get('/student', [assignmentController::class, 'listAssignmentStudent'])->middleware('can:admin');
    Route::get('/form/{id}', [assignmentController::class, 'ShowcreateAssignment'])->middleware('can:admin');
    Route::post('/newTeacherCourse', [assignmentController::class, 'newTeacherCourse']);
    Route::post('/newAssignmentStudent/{id}', [assignmentController::class, 'createAssignment']);

});

// Routes to Reports
Route::prefix('report')->group(function () {
    // TODO: change controller
    Route::get('/ticket', [StudentController::class, 'paymentTicket'])->middleware('can:admin');
    Route::get('/report', [ReportController::class, 'showGeneratePDFForm'])->middleware('can:teacher');
    Route::get('/payments', [ReportController::class, 'showReportPayments'])->middleware('can:admin');
    Route::get('/reportPaymentsMonth', [ReportController::class, 'pdfReportMonth'])->middleware('can:admin');
    Route::get('/reportPaymentsDiary', [ReportController::class, 'pdfReportDiary'])->middleware('can:admin');
    Route::get('/reportStatusMonth', [ReportController::class, 'pdfReportStatusMonth'])->middleware('can:admin');
});

// ROUTES TEACHERS
Route::prefix('teachers')->group(function () {
    Route::get('/', [TeachersController::class, 'listTeachers'])->middleware('can:admin');
    Route::get('/myCourses', [TeachersController::class, 'ListCoursesTeacher'])->middleware('can:teacher')->name('teacher.index');
    Route::get('/showForm/{id}', [TeachersController::class, 'showEdit'])->middleware('can:admin');
    Route::post('/edit/{user}', [TeachersController::class, 'editTeacher'])->middleware('can:admin');

});

// ROUTES RATINGS
Route::prefix('ratings')->group(function () {
    Route::get('/', [RatingsController::class, 'listRatings'])->middleware('can:teacher');
    Route::get('/generateRatingsPDF', [RatingsController::class, 'generateRatingsPDF'])->name('ratings.pdf');
    Route::post('/update', [RatingsController::class, 'editRatings'])->name('ratings.update');


});

//ROUTES COLLABORATIONS
Route::prefix('collaborations')->group(function () {
    Route::get('/', [CollaborationsController::class, 'listCollaborations'])->middleware('can:admin');
    Route::post('/new', [CollaborationsController::class, 'createCollaborations'])->middleware('can:admin');
    Route::put('/edit/{id}', [CollaborationsController::class, 'editCollaborations'])->middleware('can:admin');
    Route::post('/delete/{id}', [CollaborationsController::class, 'disableCollaborations'])->middleware('can:admin');
    Route::post('/restore/{id}', [CollaborationsController::class, 'activeCollaborations'])->middleware('can:admin');
    Route::get('/trash', [CollaborationsController::class, 'trashCollaborations'])->middleware('can:admin');

});

//ROUTES ACTIVITY
Route::prefix('activity')->group(function () {
    Route::get('/', [ActivityController::class, 'listActivity'])->middleware('can:teacher');
    Route::post('/new', [ActivityController::class, 'createActivity'])->middleware('can:teacher');
    Route::get('/showNew', [ActivityController::class, 'showCreate'])->middleware('can:teacher');
    Route::post('/edit/{id}', [ActivityController::class, 'editActivity'])->middleware('can:teacher');
    Route::post('/delete/{id}', [ActivityController::class, 'disableActivity'])->middleware('can:teacher');
    Route::post('/restore/{id}', [ActivityController::class, 'activeActivity'])->middleware('can:teacher');
    Route::get('/trash', [ActivityController::class, 'trashActivity'])->middleware('can:teacher');
});

// COUNT STUDENT
Route::get('/gender-counts', [assignmentController::class, 'getGenderCounts']);
