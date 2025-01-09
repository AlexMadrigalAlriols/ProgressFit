<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Helpers\ConfigurationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\UseCases\Users\StoreUseCase;
use Exception;
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

    public function register(RegisterRequest $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            $user = (new StoreUseCase(
                $request->input('name'),
                $request->input('email'),
                $request->input('phone'),
                $request->input('password'),
            ))->action();
        } catch(Exception $e) {
            return ApiResponse::fail($e->getMessage());
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return ApiResponse::fail('Invalid Credentials', [], 400);
            }
        } catch (JWTException $e) {
            return ApiResponse::fail('Server error: Could not create token.', [], 500);
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
