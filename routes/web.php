<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication routes
Auth::routes(); // Automatically handles authentication routes (login, registration, etc.)

// Public routes
Route::get('/', function () {
    return view('welcome'); // Return the welcome view for the home page
});

// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Home route
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); // Home page for authenticated users

    // Venue routes
    Route::resource('venues', VenueController::class)->middleware('role:admin'); // Resource routes for venues, accessible only by admin

    // Event routes
    Route::resource('events', EventController::class)->middleware('role:admin'); // Resource routes for events, accessible only by admin

    // Booking routes
    Route::resource('bookings', BookingController::class)->middleware('role:customer'); // Resource routes for bookings, accessible by customers

    // Admin dashboard
    Route::group(['middleware' => 'role:superUser'], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index'); // Admin dashboard route
        Route::get('/admin/events/calendar', function () {
            return view('calendar'); // Return the calendar view for admin events
        })->name('admin.calendar');
    });
});

// API routes
Route::prefix('api')->group(function () {
    Route::get('/register', function () {
        return view('register'); // Return the registration view for API
    })->name('register');
});

// Registration route for API
Route::prefix('api')->group(function () {
    Route::post('/testreg', [RegisterController::class, 'register'])->middleware('api'); // Call register method in RegisterController
});

// Commented code
// The following code is commented out for now
// Route::get('/register', function () {
//     return view('register');
// })->name('register');

// Route::prefix('api')->group(function () {
//     Route::get('/register', 'Auth\RegisterController@register');
//     // Add other API routes here
// });

// Route::match(['GET', 'POST'], '/api/register', 'Auth\RegisterController@register');

// route::post('/testreg', [RegisterController::class, 'store'])->middleware('web'); // add 'web' middleware if needed
