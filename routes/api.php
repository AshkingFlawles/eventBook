<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VenueController;

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

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);

    Route::apiResource('events', EventController::class);
    Route::apiResource('venues', VenueController::class);
});

use App\Http\Controllers\BookingController;

Route::get('/booking-trends', [BookingController::class, 'bookingTrends']);


// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);

    // Booking resource routes for authenticated users
    Route::apiResource('bookings', BookingController::class);
