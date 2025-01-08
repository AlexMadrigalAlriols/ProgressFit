<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WorkoutController;
use App\Http\Controllers\Api\WorkoutGroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [AuthController::class, 'login']);

Route::middleware('jwt.auth')->group(function() {
    Route::get('user', [AuthController::class, 'getUser']);

    Route::apiResource('workoutGroups', WorkoutGroupController::class);
    Route::apiResource('{workoutGroup}/workouts', WorkoutController::class);
});
