<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            // return response()->json(['message' => 'Invalid credentials'], 401);
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]); // More secure error message
        }

        // $user->tokens()->delete(); // Remove existing tokens for the user
        // $user->currentAccessToken()->delete(); // Remove current token

        $maxDevices = 3; // Maximum allowed devices
        $activeTokensCount = $user->tokens()->count();
        // if ($activeTokensCount >= $maxDevices) {
        //     // Delete the oldest token

        //     return response()->json([
        //         'message' => 'Maximum device limit reached. Please logout from another device to login.',
        //     ], 403);
        // }
        
        if ($activeTokensCount >= $maxDevices) {
            // Delete the oldest token
            $oldestToken = $user->tokens()->oldest()->first();
            if ($oldestToken) {
                $oldestToken->delete();
            }

            return response()->json([
                'message' => 'Maximum device limit reached. Oldest session has been logged out.',
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken; // Create a new token

        return response()->json([
            'message' => 'User logged in successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json([
            'message' => 'User details fetched successfully',
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        // $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out successfully',
        ], 200);
    }
}
