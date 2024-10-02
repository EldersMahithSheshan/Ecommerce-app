<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;

// Welcome page route
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

// Authenticated routes (only accessible if the user is logged in)
Route::middleware('auth')->group(function () {

    // Dashboard route
    Route::get('dashboard', [ProductController::class, 'dashboard'])->name('dashboard');

    // Product routes
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('', 'index')->name('products');
        Route::get('create', 'create')->name('products.create');
        Route::post('store', 'store')->name('products.store');
        Route::get('show/{id}', 'show')->name('products.show');
        Route::get('edit/{id}', 'edit')->name('products.edit');
        Route::put('edit/{id}', 'update')->name('products.update');
        Route::delete('destroy/{id}', 'destroy')->name('products.destroy');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/filter', [ProductController::class, 'filterByCategory'])->name('products.filter');
    });

    // User routes
    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('', 'index')->name('users.index');
        Route::get('create', 'create')->name('users.create');
        Route::post('store', 'store')->name('users.store');
        Route::get('show/{id}', 'show')->name('users.show');
        Route::get('edit/{id}', 'edit')->name('users.edit');
        Route::put('edit/{id}', 'update')->name('users.update');
        Route::delete('destroy/{id}', 'destroy')->name('users.destroy');
    });

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');     // List all customers
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create'); // Show form to create a customer
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');    // Store a new customer
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');  // Show a specific customer
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');  // Show form to edit a customer
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update'); // Update a customer
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Profile route
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
});
