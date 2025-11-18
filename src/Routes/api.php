<?php

use Illuminate\Support\Facades\Route;
use samkumar\Testimonials\Controllers\TestimonialController;

Route::group(['prefix' => 'api/testimonials', 'as' => 'api.testimonials.'], function () {
    // Public API routes
    Route::get('/', [TestimonialController::class, 'index'])->name('index');
    Route::get('/statistics', [TestimonialController::class, 'statistics'])->name('statistics');
    Route::get('/rating/{rating}', [TestimonialController::class, 'byRating'])->name('by-rating');
    Route::get('/{id}', [TestimonialController::class, 'show'])->name('show');

    // Protected API routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [TestimonialController::class, 'store'])->name('store');
        Route::post('/{id}', [TestimonialController::class, 'update'])->name('update');
        Route::delete('/{id}', [TestimonialController::class, 'destroy'])->name('destroy');
    });

    // Admin API routes (require permission)
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::post('/{id}/approve', [TestimonialController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [TestimonialController::class, 'reject'])->name('reject');
    });
});
