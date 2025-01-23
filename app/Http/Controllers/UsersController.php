<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    function __construct()
    {
        $this->users = new Users();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8'
        ]);
        // check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        // check if email already exists
        $email = $request->input('email');
        $checkEmail = $this->users->where('email', $email)->first();
        if ($checkEmail) {
            return response()->json([
                'code' => 400,
                'message' => 'Email already exists'
            ], 400);
        }

        // create users and password hash
        $params = [
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => md5($request->input('password'))
        ];
        $this->users->createUser($params);
        return response()->json([
            'code' => 200,
            'message' => 'Users created successfully'
        ], 200);
    }
}
