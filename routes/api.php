<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('profile', [AuthController::class, 'profile'])->middleware('auth:api');
});

// Public route to get a single user info
Route::get('get-single-user-info', [AuthController::class, 'getSingleUser']);

// Protect `create`, `update`, and `delete` routes with 'auth:api' middleware
Route::apiResource('categories', CategoryController::class)->except(['store', 'update', 'destroy']);
Route::apiResource('posts', PostController::class)->except(['store', 'update', 'destroy']);
Route::apiResource('comments', CommentController::class)->except(['store', 'update', 'destroy']);

// Private routes for creating, updating, and deleting categories
Route::post('categories', [CategoryController::class, 'store'])->middleware('auth:api');
Route::put('categories/{category}', [CategoryController::class, 'update'])->middleware('auth:api');
Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->middleware('auth:api');

// Private routes for creating, updating, and deleting posts
Route::post('posts', [PostController::class, 'store'])->middleware('auth:api');
Route::put('posts/{post}', [PostController::class, 'update'])->middleware('auth:api');
Route::delete('posts/{post}', [PostController::class, 'destroy'])->middleware('auth:api');

// Private routes for creating, updating, and deleting posts
Route::post('comments', [CommentController::class, 'store'])->middleware('auth:api');
Route::put('comments/{post}', [CommentController::class, 'update'])->middleware('auth:api');
Route::delete('comments/{post}', [CommentController::class, 'destroy'])->middleware('auth:api');
