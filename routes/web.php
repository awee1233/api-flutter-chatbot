<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ChatbotProviderController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::controller(ChatbotProviderController::class)->group(function () {
            Route::get('/providers', 'index')->name('admin.providers.index');
            Route::get('/providers/create', 'create')->name('admin.providers.create');
            Route::post('/providers', 'store')->name('admin.providers.store');
            Route::get('/providers/{provider}/edit', 'edit')->name('admin.providers.edit');
            Route::put('/providers/{provider}', 'update')->name('admin.providers.update');
            Route::delete('/providers/{provider}', 'destroy')->name('admin.providers.destroy');
        });
    });

    // Chat routes
    Route::controller(ChatController::class)->group(function () {
        Route::get('/chat', 'index')->name('chat');
        Route::post('/chat/send', 'send')->name('chat.send');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
