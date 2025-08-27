<?php

namespace App\Http\Controllers;
use App\Models\Festival;
use App\Models\User;

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
            'user' => $user,
            'token' => $token,
            
        ]);
    }

    public function login(Request $request)
    {
        
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
           
        ]);
        
    
        // Attempt to authenticate the user
        if(!\Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }
        // Get the authenticated user
        $user = \Auth::user();


        
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token,
        ]);
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

    // FestivalFilmController.php

public function store(Request $request)
{
    $request->validate([
        'festival_id' => 'required|exists:festivals,id',
        'film_id' => 'required|exists:films,id',
        'status' => 'required|string|max:255', 
        'decision_date' => 'required|date', 
        'comments' => 'nullable|string|max:500', 

        // add more if you have additional fields like 'status'
    ]);

    try {
        $festival = Festival::findOrFail($request->festival_id);
        $festival->films()->attach($request->film_id, [
            'status' => $request->status,
            'decision_date' => $request->decision_date,
            'comments' => $request->comments,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Film assigned to festival successfully',
            'data' => [
                'festival_id' => $festival->id,
                'film_id' => $request->film_id,
                'status' => $request->status,
                'decision_date' => $request->decision_date,
                'comments' => $request->comments,
            ]
        ])->setStatusCode(201
        );
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to assign film to festival.',
            'error' => $e->getMessage()
        ], 500);
    }
}
}

