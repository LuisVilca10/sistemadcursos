<?php

use App\Http\Controllers\Admin\Course\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login_tienda', [AuthController::class, 'login_tienda'])->name('login_tienda');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

Route::group([
    'middleware' => 'api'
], function ($router) {
    //usuarios
    Route::post('/users/{id}', [UserController::class, "update"])->middleware('auth:api');
    Route::resource('/users', UserController::class)->middleware('auth:api');
    //categorias
    Route::post('/categories/{id}', [CategoryController::class, "update"])->middleware('auth:api');
    Route::resource('/categories', CategoryController::class)->middleware('auth:api');
});
