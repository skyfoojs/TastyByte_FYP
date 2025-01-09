<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Get the view from Login Controller.
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Get the view from Product Controller.
Route::get('/order', [ProductController::class, 'index'])->name('order');

// Get the view from Menu Controller.
Route::get('/menu', [MenuController::class, 'mainMenu'])->name('mainMenu');

// Get the view from Table Controller.
Route::get('/table', [OrdersController::class, 'index'])->name('table');