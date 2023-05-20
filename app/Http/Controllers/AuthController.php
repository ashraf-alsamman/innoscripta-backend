<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(Request $request):JsonResponse

    {

        try {
            $user = User::create([
                'name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken($request->device_name ?? 'web')->plainTextToken;
            return response()->json([
                'message' => 'User registered successfully', 'user' => $user, 'token' => $token
            ], 201);
        } catch (\Exception $e) {
            // Handle the exception here
            return response()->json([
                'message' => 'User registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request):JsonResponse
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return response()->json(['error' => 'The provided credentials are incorrect.'], 500);
        }

        try {
            if (!Hash::check($validatedData['password'], $user->password)) {
                return response()->json(['error' => 'The provided credentials are incorrect.'], 500);
            }
            return response()->json(['status' => true ,'token' => $user->createToken($request->email)->plainTextToken], 200);

         } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
