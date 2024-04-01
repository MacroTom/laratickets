<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agent\AuthController;
use App\Http\Controllers\Agent\ProfileController;
use App\Http\Controllers\Agent\TicketController;
use App\Http\Middleware\AgentStatus;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', AgentStatus::class])->group(function(){

    Route::prefix('profile')->group(function(){
        Route::post('/update', [ProfileController::class, 'update']);
        Route::post('/change-password', [ProfileController::class, 'changePassword']);
    });

    Route::prefix('tickets')->group(function(){
        Route::post('/all', [TicketController::class, 'index']);
        Route::post('/reply/{ticket_id}', [TicketController::class, 'reply']);
    });

    Route::post('/logout', [AuthController::class, 'logout'])
    ->withoutMiddleware([AgentStatus::class]);
});
