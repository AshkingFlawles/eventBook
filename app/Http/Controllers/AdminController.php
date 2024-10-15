<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // assuming your User model is in App\Models namespace
use App\Models\Event; // assuming your Event model is in App\Models namespace
use App\Models\Booking; // assuming your Booking model is in App\Models namespace
use App\Models\Venue; // assuming your Booking model is in App\Models namespace

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