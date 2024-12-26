<?php

namespace App\Http\Controllers\Auth; // Namespace declaration for the Auth controllers

use App\Http\Controllers\Controller; // Import the base controller
use App\Models\User; // Import the User model
use Illuminate\Foundation\Auth\RegistersUsers; // Trait for user registration functionality
use Illuminate\Support\Facades\Hash; // Facade for hashing passwords
use Illuminate\Support\Facades\Validator; // Facade for validating data
use Illuminate\Http\Request; // Import the Request class
use Illuminate\Contracts\View\Factory; // Import the Factory interface for view rendering
use Illuminate\Contracts\View\View; // Import the View interface for view rendering

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers; // Use the RegistersUsers trait for registration functionality

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Redirect path after successful registration

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest'); // Ensure only guests can access registration
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(): Factory|View
    {
        return view('auth.register'); // Return the registration view
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'], // Name must be a string and required
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Email must be unique and valid
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Password must be confirmed and at least 8 characters
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'], // Create a new user with the provided name
            'email' => $data['email'], // Create a new user with the provided email
            'password' => Hash::make($data['password']), // Hash the password before saving
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all()); // Validate the incoming request data
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Return validation errors
        }

        $user = $this->create($request->all()); // Create a new user
        return response()->json(['user' => $user], 201); // Return success response with user data
    }
}
