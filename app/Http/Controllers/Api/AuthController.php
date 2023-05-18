<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(LoginRequest $request)
    {

        try {
            $credentials = $request->only('email', 'password');

            $token = Auth::attempt($credentials);
            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 401);
            }

            $user = Auth::user();
            return response()->json([
                    'status' => 'success',
                    'user' => UserResource::make($user),
                    'authorisation' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ]
                ]);


        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function register(RegisterRequest $request){
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = Auth::login($user);
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => UserResource::make($user),
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out',
            ]);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }


    public function refresh()
    {
        try {
            return response()->json([
                'status' => 'success',
                'user' => UserResource::make(Auth::user()),
                'authorisation' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ]
            ]);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }


}
