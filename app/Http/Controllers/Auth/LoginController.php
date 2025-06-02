<?php

namespace App\Http\Controllers\Auth;

// Authentication Controller - Handles login and session management
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log; // Import Log facade
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

// To check authentication status in Laravel routes or controllers:
// 1. Using Auth facade:
//    - Auth::check() - returns boolean if user is logged in
//    - Auth::id() - returns authenticated user ID
//    - Auth::user() - returns authenticated user object
//    - Auth::guest() - returns true if user is not logged in

// 2. Using session:
//    - session('user') - retrieves user data from session
//    - session()->has('user') - checks if user data exists in session

// 3. In routes/web.php:
//    Route::middleware(['auth'])->group(function () {
//        // Protected routes here
//    });

// 4. In blade templates:
//    @auth
//        // User is authenticated
//    @endauth

//    @guest
//        // User is not authenticated
//    @endguest

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/api/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                
                $user = Auth::user();
                
                // Set the session with user data
                $request->session()->put('user', $user->toArray());
                
                // Redirect to dashboard
                return redirect()->to('/api/dashboard');
            }
            
            return response()->json([
                'authenticated' => false,
                'message' => 'Invalid credentials'
            ], 401);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Handle user logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Clear the session
        $request->session()->flush();
        
        // Regenerate session ID
        $request->session()->regenerate();
        
        // Clear any stored user data
        $request->session()->put('user', null);
        
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}