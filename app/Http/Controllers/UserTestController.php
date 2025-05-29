<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTest;

class UserTestController extends Controller
{
    //index method
    // public function index()
    // {
    //     return response()->json(UserTest::all());
    // }


    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $users = UserTest::paginate($perPage);
        return response()->json($users);
    }
    






//     public function index(Request $request)
// {
//     $perPage = $request->get('per_page', 10); // dynamic control with default fallback
//     $users = UserTest::paginate($perPage);    // paginate instead of all()

//     return response()->json($users);          // return the paginated result
// }

//store method
}