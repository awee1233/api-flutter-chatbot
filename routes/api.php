<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ChatController;

// Public Routes with Rate Limiting
Route::middleware('api.limit')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected Routes
Route::middleware(['auth:sanctum', 'api.limit'])->group(function () {
    // Auth Routes
    Route::post('/logout', [AuthController::class, 'logout']);

    // Chat Routes
    Route::prefix('chat')->group(function () {
        Route::get('/', [ChatController::class, 'index']);
        Route::post('/message', [ChatController::class, 'send']);
        Route::get('/providers', [ChatController::class, 'getProviders']);
    });

    // Provider Management Routes
    Route::prefix('providers')->group(function () {
        Route::post('/', [ChatController::class, 'addProvider']);
        Route::put('/{id}', [ChatController::class, 'updateProvider']);
        Route::delete('/{id}', [ChatController::class, 'deleteProvider']);
        Route::patch('/{id}/toggle', [ChatController::class, 'toggleProvider']);
    });
});
