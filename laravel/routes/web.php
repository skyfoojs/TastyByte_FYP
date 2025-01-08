<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Get the view from Login Controller.
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Get the view from Product Controller.
Route::get('/menu', [ProductController::class, 'index'])->name('menu');
