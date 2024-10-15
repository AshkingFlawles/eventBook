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



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('venues', VenueController::class)->middleware('role:admin');
Route::resource('events', EventController::class)->middleware('role:admin');
Route::resource('bookings', BookingController::class)->middleware('role:customer');

Route::group(['middleware' => 'role:superUser'], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});
// vuejs and php laravel
// Route::get('/register', function () {
//     return view('register');
// })->name('register');


// ...

// API Routes
// Route::prefix('api')->group(function () {
//     Route::get('/register', 'Auth\RegisterController@register');
//     // Add other API routes here
// });


//test for vue app and form registration via api system :)perfect
Route::prefix('api')->group(function () {
    Route::get('/register', function () {
        return view('register');
    })->name('register');

    // Route::match(['GET', 'POST'], '/api/register', 'Auth\RegisterController@register');
}); // test route for vue js to register

Route::middleware(['auth', 'role:superUser'])->group(function () {
    Route::get('/admin/events/calendar', function () {
        return view('calendar');
    })->name('admin.calendar');
    
    Route::resource('events', EventController::class);
});


// Routes for all users
Route::get('/', function () {
    return view('welcome');
});


route::post('/testreg', [RegisterController::class, 'store'])->middleware('web'); // add 'web' middleware if needed

// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Venue Routes
    Route::resource('venues', VenueController::class)->middleware('role:admin');
    // Event Routes
    Route::resource('events', EventController::class)->middleware('role:admin');
    // Booking Routes
    Route::resource('bookings', BookingController::class)->middleware('role:customer');
    
    // Admin Dashboard
    Route::group(['middleware' => 'role:superUser'], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::resource('/vens', VenueController::class);
        
    });
    // Route::group(['middleware' => 'role:superUser'], function () {
    // Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    // Route::resource('/vens', VenueController::class);
// });


});
