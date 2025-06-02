<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            // Clear session and redirect to login
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }
        
        return response()->json([
            'user' => $user
        ]);
    }
}
