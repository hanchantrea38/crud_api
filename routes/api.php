<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::apiResource('categories',CategoryController::class);
Route::apiResource('categories', CategoryController::class)->names([
    'index'   => 'api.categories.index',
    'store'   => 'api.categories.store',
    'show'    => 'api.categories.show',
    'update'  => 'api.categories.update',
    'destroy' => 'api.categories.destroy',
]);

Route::apiResource('products', ProductController::class)->names([
    'index'   => 'api.products.index',
    'store'   => 'api.products.store',
    'show'    => 'api.products.show',
    'update'  => 'api.products.update',
    'destroy' => 'api.products.destroy',
]);

Route::apiResource('customers', CustomerController::class)->names([
    'index'   => 'api.customers.index',
    'store'   => 'api.customers.store',
    'show'    => 'api.customers.show',
    'update'  => 'api.customers.update',
    'destroy' => 'api.customers.destroy',
]);

Route::apiResource('movies', MovieController::class)->names([
    'index'   => 'api.movies.index',
    'store'   => 'api.movies.store',
    'show'    => 'api.movies.show',
    'update'  => 'api.movies.update',
    'destroy' => 'api.movies.destroy',
]);




