<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductDetailsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Get the view from Login Controller.
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Get the login credentials from the view.
Route::post('/login', [LoginController::class, 'loginPost'])->name('login.post');

// Get the view from Product Controller.
Route::get('/order', [ProductController::class, 'index'])->name('order');

// Get the view from Menu Controller.
Route::get('/menu', [MenuController::class, 'mainMenu'])->name('menu');

// Get the view from Table Controller.
Route::get('/table', [OrdersController::class, 'index'])->name('table');

// Get the view from Product Details Controller.
Route::get('/product-details/{id}', [ProductController::class, 'edit'])->name('product-details');

// Get the User Page view from Admin Controller.
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin-users');

// Get the Create Users data from the View.
Route::post('/admin/users', [AdminController::class, 'addUserPost'])->name('addUser.post');

// Get the Edit Users Data from the View.
Route::put('/admin/users', [AdminController::class, 'editUserPost'])->name('editUser.post');