<?php

// routes/web.php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GolfCourseController;
use App\Http\Controllers\GolfTourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Golf Courses
Route::prefix('courses')->name('courses.')->group(function () {
    Route::get('/', [GolfCourseController::class, 'index'])->name('index');
    Route::get('/{slug}', [GolfCourseController::class, 'show'])->name('show');
    Route::get('/{slug}/holes', [GolfCourseController::class, 'holes'])->name('holes');
});

// Golf Tours
Route::prefix('tours')->name('tours.')->group(function () {
    Route::get('/', [GolfTourController::class, 'index'])->name('index');
    Route::get('/{slug}', [GolfTourController::class, 'show'])->name('show');
});

// Vendors
Route::prefix('vendors')->name('vendors.')->group(function () {
    Route::get('/', [VendorController::class, 'index'])->name('index');
    Route::get('/{slug}', [VendorController::class, 'show'])->name('show');
});

// Bookings
Route::prefix('bookings')->name('bookings.')->group(function () {
    Route::get('/{courseSlug}/create', [BookingController::class, 'create'])->name('create');
    Route::get('/availability/{courseId}', [BookingController::class, 'availability'])->name('availability');
    Route::post('/', [BookingController::class, 'store'])->name('store');
    
    // Authenticated routes
    Route::middleware('auth')->group(function () {
        Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my-bookings');
        Route::get('/{id}', [BookingController::class, 'show'])->name('show');
        Route::get('/{id}/payment', [BookingController::class, 'payment'])->name('payment');
        Route::post('/{id}/cancel', [BookingController::class, 'cancel'])->name('cancel');
    });
});

// Language & Currency Switchers
Route::post('/language/{code}', [LanguageController::class, 'switch'])->name('language.switch');
Route::post('/currency/{code}', [CurrencyController::class, 'switch'])->name('currency.switch');

// Authentication Routes (Laravel Breeze/Jetstream)
require __DIR__.'/auth.php';

?>