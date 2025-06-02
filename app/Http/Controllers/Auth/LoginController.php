<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log; // Import Log facade
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

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
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if ($request->wantsJson()) {
                return response()->json([
                    'authenticated' => true,
                    'user' => Auth::user(),
                    'csrf' => csrf_token()
                ]);
            }
            
            return redirect()->intended('/api/dashboard');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'authenticated' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->onlyInput('email');
    }
    }
}