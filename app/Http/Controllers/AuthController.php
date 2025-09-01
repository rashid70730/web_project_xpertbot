<?php

namespace App\Http\Controllers;
use App\Models\Festival;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:filmmaker,viewer,admin,festival organizer', 
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role, 
            
        ]);
        $user->save();
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'token' => $token,
            
        ]);
    }

    public function login(Request $request)
    {
        
    
        // 1. Validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // 2. Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Email not found.'
            ], 404);
        }

        // 3. Check password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Incorrect password.'
            ], 401);
        }

        // 4. each token to carry its role
        $token = $user->createToken('auth_token', [$user->role])->plainTextToken;

        // 5. Return response
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the request
        $request->user()->currentAccessToken()->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully',
        ]);
    }

    public function index()
    {
        // Logic to list all films
        $user = User::all();
        return response()->json([
            'success' => true,
            'data' => $user,
        ]);

    }


}

