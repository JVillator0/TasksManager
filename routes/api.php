<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::patch('/tasks/reorder', [TaskController::class, 'reorder']);
Route::apiResource('/tasks', TaskController::class);
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle']);

Route::apiResource('/projects', ProjectController::class);
