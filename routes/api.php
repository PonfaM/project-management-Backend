<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', [TestController::class, 'index']);
Route::apiResource('/projects', ProjectController::class)->middleware('auth:sanctum');
Route::apiResource('/tasks', TaskController::class)->middleware('auth:sanctum');

//Register a new user
Route::post('/register', [AuthController::class, 'register']);
//Login a user
Route::post('/login', [AuthController::class, 'login']);
//Logout a user
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
