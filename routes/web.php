<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;

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
Route::get('/', function () {
return view('profile-perusahaan.main');
});

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', function () {
return view('dashboard.main');
})->middleware('auth')->middleware('guest');

Route::get('/dashboard/profile/{user}/edit', [UsersController::class, 'edit'])->middleware(['auth']);
Route::put('/profile/{user}', [UsersController::class, 'update']);

Route::get('/task', [TaskController::class, 'index'])->middleware(['auth']);

Route::get('/task/{task}', [TaskController::class, 'show'])->middleware(['auth']);

Route::get('/task/form/{task}/edit', [TaskController::class, 'edit'])->middleware(['auth']);
Route::put('/task/form/{task}', [TaskController::class, 'update']);

Route::post('/task/create', [TaskController::class, 'create']);
