<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Helpers\ConfigurationHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return ApiResponse::ok([
            'token' => $token,
            'user' => auth()->user(),
        ]);
    }

    public function getUser(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        return ApiResponse::ok([
            'user' => auth()->user(),
        ]);
    }
}
