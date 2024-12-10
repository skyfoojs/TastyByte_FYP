<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Get the view from Login Controller, and call the login() function.
Route::get('/login', [LoginController::class, 'index'])->name('login');