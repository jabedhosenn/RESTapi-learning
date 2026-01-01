<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Task2Controller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        Route::get('/get-all-task', [TaskController::class, 'getAllTask']);
        Route::post('/tasks/create', [TaskController::class, 'store']);
        Route::get('/tasks/edit/{id}', [TaskController::class, 'edit']);
        Route::post('/tasks/update/{id}', [TaskController::class, 'update']);
        Route::delete('/tasks/delete/{id}', [TaskController::class, 'destroy']);

        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/categories-with-products', [CategoryController::class, 'categoryWithProducts']);
    });

    Route::post('/test', [TaskController::class, 'test']);

    Route::apiResource('tasks', TaskController::class);
});

Route::prefix('v2')->group(function () {
    Route::apiResource('tasks', Task2Controller::class);
});
