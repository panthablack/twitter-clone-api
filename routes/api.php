<?php

use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users/{user}', [UserController::class, 'show']);
Route::get('/users/{user}/tweets', [UserController::class, 'tweets']);

Route::apiResource('tweets', TweetController::class);
