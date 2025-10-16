<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Event; 
use App\Models\Booking; 
use App\Models\Venue; 

class AdminController extends Controller
{
    public function index()
    {
        $venues = Venue::all();
        $events = Event::all();
        $bookings = Booking::all();
    
        return view('admin.dashboard', compact('venues', 'events', 'bookings'));
    }
    
    
    public function users() {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function events() {
        $events = Event::all();
        return view('admin.events', compact('events'));
    }

    public function bookings() {
        $bookings = Booking::all();
        return view('admin.bookings', compact('bookings'));
    }
}
