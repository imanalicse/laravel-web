<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginApiController extends Controller
{
    public function loginApi(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;
        /*
        $token = $user->createToken(
            $request->device_name, ['*'], now()->addMinutes(60)
        )->plainTextToken;
        */

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            // 'expires_in' => 60 * 60,
            'user' => $user,
        ]);
    }

    public function logoutApi(Request $request)
    {
        $request->user()->tokens()->delete();
        // Revoke a specific token...
        // $user->tokens()->where('id', $tokenId)->delete();
        return response([
            'success' => true
        ]);
    }

    public function getProfile(Request $request): \Illuminate\Http\JsonResponse {
        $user = $request->user();
        return response()->json([
            'data' => $user
        ]);
    }
}
