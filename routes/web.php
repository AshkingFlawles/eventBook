<?php

use App\Http\Controllers\UserTestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
/*
Route::post('/api/login', [LoginController::class, 'login'])->middleware('web');
*/
Route::post('/api/logout', [LoginController::class, 'logout']);

// Public routes
Route::get('api/home', function () {
    return view('home');
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/api/dashboard', [DashboardController::class, 'index']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

Route::prefix('api')->group(function () {
    Route::get('/admin/register', function () {
        return view('adminRegisterForm'); // Return the registration view for API
    })->name('adminRegisterForm');
});

//Dashboard 
Route::prefix('api')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Return the dashboard view
    })->name('dashboard');
});

//Login 
Route::prefix('api')->group(function () {
    Route::get('/login', function () {
        return view('login'); // Return the Login view for API
    })->name('login');
});

Route::prefix('api')->group(function () {
    Route::get('/int', [UserTestController::class, 'index']);
});

Route::get('/user-table', function () {
    return view('usertest');
});

Route::post('api/login2', [LoginController::class, 'login'])->middleware('api'); // Call login method in LoginController

// The following routes are commented out for reference
/*
Route::get('/api/int', [LoginController::class, 'users']);

Route::prefix('api')->group(function () {
    Route::get('/int', function () {
        $users = User::all();
        return response()->json($users);
    });
});

Route::prefix('api')->group(function () {
    Route::get('/int', [LoginController::class, 'users']);
});

Route::post('/login', [LoginController::class, 'login']);

Route::get('/admin/register', function () {
    return view('adminRegisterForm'); // Return the admin registration form view
})->middleware('role:admin'); // Ensure only admin users can access this route

Route::prefix('api')->group(function () {
    Route::get('/register', 'Auth\RegisterController@register');
    // Add other API routes here
});

Route::match(['GET', 'POST'], '/api/register', 'Auth\RegisterController@register');

route::post('/testreg', [RegisterController::class, 'store'])->middleware('web'); // add 'web' middleware if needed
*/
