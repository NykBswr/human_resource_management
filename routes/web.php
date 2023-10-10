<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', function () {
return view('signin.main');
});

Route::get('/dashboard', function () {
return view('dashboard.main');
});

Route::get('/dashboard/profile', function () {
return view('dashboard.profile.main');
});
