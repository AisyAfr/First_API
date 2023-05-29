<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/post/{id}',[ PostController::class, 'show']);
Route::get('/post',[ PostController::class, 'index']);
Route::post('/post', [PostController::class, 'store']);
Route::patch('/post/{id}', [PostController::class, 'update']);
Route::delete('/post/{id}', [PostController::class, 'delete']);

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me']);

Route::post('/comment', [CommentController::class, 'store']);
Route::patch('/comment/{id}', [CommentController::class, 'update']);
Route::delete('/comment/{id}', [CommentController::class, 'delete']);
