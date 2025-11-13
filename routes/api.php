<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Public Routes
Route::post('/login', [AuthController::class, 'logIn']);
Route::post('/register', [AuthController::class, 'register']);

// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth Routes
    Route::get('/auth-user', [AuthController::class, 'authUser']);
    Route::post('/logout', [AuthController::class, 'logOut']);

    // User Routes
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::get('/users/{user}/tweets', [UserController::class, 'tweets']);

    // Tweet Routes
    Route::apiResource('tweets', TweetController::class);
});
