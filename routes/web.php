<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;

// Redirect root ke register
Route::get('/', function () {
    return redirect()->route('register');
});

// Auth Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/room/{id}', [HomeController::class, 'show'])->name('room.show');
    
    // Booking
    Route::get('/booking/create/{roomId}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/confirm/{id}', [BookingController::class, 'confirm'])->name('booking.confirm');
    Route::post('/booking/verify-otp/{id}', [BookingController::class, 'verifyOtp'])->name('booking.verifyOtp');
    Route::get('/booking/success/{id}', [BookingController::class, 'success'])->name('booking.success');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('booking.myBookings');


    //metrics endpoint
    Route::get('/metrics', [App\Http\Controllers\MetricsController::class, 'metrics']);
});