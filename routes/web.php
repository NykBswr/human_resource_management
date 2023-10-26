<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OffdaysController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollandBenefitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// MAIN
Route::get('/', function () {
return view('profile-perusahaan.main');
});

// LOGIN
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);


// DASHBOARD
Route::get('/dashboard', function () {
return view('dashboard.main');
})->middleware('auth')->middleware('guest');


// USER
Route::get('/dashboard/profile/{user}/edit', [UsersController::class, 'profile'])->middleware(['auth']);
Route::put('/profile/{user}', [UsersController::class, 'updateimage']);

Route::get('/createuser', [UsersController::class, 'create']);
Route::post('/adduser', [UsersController::class, 'store']);

Route::get('/userlist', [UsersController::class, 'list']);

Route::get('/userlist/edituser/{user}', [UsersController::class, 'edituser']);
Route::post('/userlist/updateuser/{user}', [UsersController::class, 'userupdated']);
Route::delete('/userlist/delete/{user}', [UsersController::class, 'deleteuser']);

Route::get('/dashboard/changepassword/{user}', [UsersController::class, 'changepassword']);
Route::post('/dashboard/changes/{user}', [UsersController::class, 'change']);

// TASK
Route::get('/task', [TaskController::class, 'index'])->middleware(['auth']);

Route::get('/task/{task}', [TaskController::class, 'show'])->middleware(['auth']);

Route::get('/task/form/{task}/edit', [TaskController::class, 'edit'])->middleware(['auth']);
Route::put('/task/form/{task}', [TaskController::class, 'update']);
Route::put('/task/edit/{task}', [TaskController::class, 'edittask']);

Route::get('/createtask', [TaskController::class, 'createtask']);
Route::post('/task/create', [TaskController::class, 'create']);

Route::delete('/task/{task}', [TaskController::class, 'destroy']);

Route::get('/task/feedback/{id}', [TaskController::class, 'feedback']);
Route::post('task/inputfeedback/{id}', [TaskController::class, 'inputfeedback']);

// FACILITY
Route::get('/facility', [FacilityController::class,'index']);

Route::get('/facility/addfacility', [FacilityController::class, 'addfacility']);
Route::post('/facility/add', [FacilityController::class, 'add']);

Route::get('/facility/employeeadd', [FacilityController::class, 'employeeadd']);
Route::post('/facility/addemployee', [FacilityController::class, 'addEmployeeFacility']);

Route::get('/facility/edit/{facility}', [FacilityController::class, 'edit']);
Route::post('/facility/update/{facility}', [FacilityController::class, 'update']);

Route::delete('/facility/{facility}', [FacilityController::class, 'destroy']);

// ATTENDANCE
Route::get('/attendance', [AttendanceController::class,'index']);
Route::get('/attendance/createattend', [AttendanceController::class,'createattend']);

Route::post('/attendance/present/{employee}', [AttendanceController::class,'present']);

// OFF DAYS
Route::get('/offdays', [OffdaysController::class,'index']);

Route::get('/sumbitapplication', [OffdaysController::class,'applications']);
Route::post('/addoffdays', [OffdaysController::class,'addoffdays']);

Route::post('/offdays/refuse/{offday}', [OffdaysController::class,'refuse']);
Route::post('/offdays/approve/{offday}', [OffdaysController::class,'approve']);

// PAYROLL AND BENEFIT
Route::get('/PayrollandBenefit', [PayrollandBenefitController::class,'index']);

Route::get('/PayrollandBenefit/applyform', [PayrollandBenefitController::class,'formapply']);
Route::post('/PayrollandBenefit/apply', [PayrollandBenefitController::class,'apply']);

Route::get('/PayrollandBenefit/acceptedapplication/{user}', [PayrollandBenefitController::class,'acceptedapplication']);
Route::post('/PayrollandBenefit/process/{user}', [PayrollandBenefitController::class,'process']);

Route::get('/PayrollandBenefit/editbenefit/{benefit}',[PayrollandBenefitController::class,'editbenefit']);
Route::post('/PayrollandBenefit/edit/{benefit}',[PayrollandBenefitController::class,'edited']);
Route::delete('/PayrollandBenefit/delete/{benefit}', [FacilityController::class, 'delete']);
