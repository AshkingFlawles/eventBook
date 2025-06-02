<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // If it's an API request, return JSON
        if ($request->wantsJson()) {
            return response()->json([
                'user' => $user,
                'data' => 'Dashboard data here'
            ]);
        }
        
        // For web requests, return the view
        return view('dashboard', compact('user'));
    }
}
