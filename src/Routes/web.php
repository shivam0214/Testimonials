<?php

use Illuminate\Support\Facades\Route;
use samkumar\Testimonials\Controllers\TestimonialController;

Route::group(['prefix' => 'testimonials', 'as' => 'testimonials.'], function () {
    // Public routes
    Route::get('/', [TestimonialController::class, 'index'])->name('index');
    Route::get('/{id}', [TestimonialController::class, 'show'])->name('show');
    Route::get('/create', [TestimonialController::class, 'create'])->name('create');

    // Protected routes (require authentication)
    Route::middleware('auth')->group(function () {
        Route::post('/', [TestimonialController::class, 'store'])->name('store');
        Route::put('/{id}', [TestimonialController::class, 'update'])->name('update');
        Route::delete('/{id}', [TestimonialController::class, 'destroy'])->name('destroy');
    });

    // Admin routes (require permission)
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::post('/{id}/approve', [TestimonialController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [TestimonialController::class, 'reject'])->name('reject');
    });
});
