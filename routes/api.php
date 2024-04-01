<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\TicketController;

Route::post('/register', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('tickets')->group(function(){
        Route::post('/create', [TicketController::class, 'store']);
        Route::post('/reply/{ticket_id}', [TicketController::class, 'reply']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('agent')->group(__DIR__ . '/agent.php');
Route::prefix('admin')->group(__DIR__ . '/admin.php');
