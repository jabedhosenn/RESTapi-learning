<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::post('/test', [TaskController::class, 'test']);
Route::get('/get-all-task', [TaskController::class, 'getAllTask']);
Route::post('/tasks/store', [TaskController::class, 'store']);
Route::get('/tasks/edit/{id}', [TaskController::class, 'edit']);
Route::delete('/tasks/delete/{id}', [TaskController::class, 'destroy']);
