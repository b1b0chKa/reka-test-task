<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TaskController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.api')->group(function () {
	Route::apiResource('tasks', TaskController::class);

	Route::get('/tags', [TagController::class, 'index']);
	Route::post('/tags', [TagController::class, 'store']);
	Route::patch('/tasks/sort', [TaskController::class, 'sort']);
});