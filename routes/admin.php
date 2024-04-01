<?php

use App\Http\Controllers\Admin\AgentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('profile')->group(function(){
        Route::post('/update', [ProfileController::class, 'update']);
        Route::post('/change-password', [ProfileController::class, 'changePassword']);
    });

    Route::prefix('agents')->group(function(){
        Route::post('/all', [AgentController::class, 'index']);
        Route::post('/add', [AgentController::class, 'store']);
        Route::post('/enable', [AgentController::class, 'enable']);
        Route::post('/disable', [AgentController::class, 'disable']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
