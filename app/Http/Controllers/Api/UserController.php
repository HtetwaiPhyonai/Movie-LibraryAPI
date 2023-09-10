<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * user login
     */

    public function login(Request $request)
    {
        $validate = $request->all();
        $validator = Validator::make($validate,[
            'email' => 'required|max:255',
            'password' => 'required|min:8'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'error' => $validator->errors()
            ], 422);
        };


        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Login Fail.',
            ], 401);
        }
        $user = User::where('email', $request->email)->first();
        return response()->json([
            'status' => true,
            'message' => 'Login Success.',
            'token' =>  $user->createToken('Token Name')->accessToken,
            'data' => $user
        ], 200);
    }

    /**
     * user register
     */

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Register successful',
            'data' => $user
        ], 201);
    }
}
