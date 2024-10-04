<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;



Route::post('/auth/register',[CustomerController::class, 'register']);
Route::post('/auth/login',[CustomerController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'apiIndex']);           // GET all products
    Route::post('/', [ProductController::class, 'apiStore']);          // POST create a new product
    Route::get('/{id}', [ProductController::class, 'apiShow']);        // GET a single product by ID
    Route::put('/{id}', [ProductController::class, 'apiUpdate']);      // PUT update a product by ID
    Route::delete('/{id}', [ProductController::class, 'apiDestroy']);  // DELETE a product by ID
});

Route::get('/customers', [CustomerController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    // Protect customer-related routes

    Route::get('/customers/{id}', [CustomerController::class, 'show']);
    Route::put('/customers/{id}', [CustomerController::class, 'update']);
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/customer', [CustomerController::class, 'getLoggedInCustomer']);




