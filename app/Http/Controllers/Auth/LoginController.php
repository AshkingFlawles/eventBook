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
    protected $redirectTo = '/home';

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


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function login(Request $request)
     {
         // Validate input
         $request->validate([
             'email' => 'required|email',
             'password' => 'required'
         ]);
 
         // Attempt login
         if (Auth::attempt($request->only('email', 'password'))) {
             return response()->json(['message' => 'Logged in successfully']);
         }
 
         return response()->json(['message' => 'Invalid email or password'], 401);
     }

     // create a mthod that returns all the users in json format 
     public function users()
     {
        $users = User::all();
        //return json 
        return response()->json($users);
     }
}