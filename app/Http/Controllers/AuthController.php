<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function __construct()
    {
        $this->users = new Users();
    }

    public function auth(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
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

        // check if email and password is correct
        $email = $request->input('email');
        $password = $request->input('password');
        $auth = $this->users->auth($email, md5($password));
        if (!$auth) {
            return response()->json([
                'code' => 400,
                'message' => 'Email or password is incorrect'
            ], 400);
        }

        // set session
        Session::put('id', $auth->id);
        Session::put('email', $auth->email);
        Session::put('firstname', $auth->firstname);

        return response()->json([
            'code' => 200,
            'message' => 'Login successful',
            'data' => Session::all()
        ], 200);
    }

    public function logout(){
        Session::flush();
        return response()->json([
            'code' => 200,
            'message' => 'Logout successful',
        ], 200);
    }
    
}
