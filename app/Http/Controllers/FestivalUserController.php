<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FestivalUser;
use App\Models\User;
use App\Models\Festival;


class FestivalUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'festival_id' => 'required|exists:festivals,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:filmmaker,viewer',
        ]);

        $festivalUser = FestivalUser::create($validated);

        return response()->json($festivalUser, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Get the list of users for a specific festival.
     */
    public function getUsersByFestival($festivalId)
    {
        $users = FestivalUser::where('festival_id', $festivalId)->with('user')->get();  
        return response()->json($users);
        

    }
    /**
     * Get the list of festivals for a specific user.
     */
    public function getFestivalsByUser($userId)
    {
        $festivals = FestivalUser::where('user_id', $userId)->with('festival')->get();
        return response()->json($festivals);  
        
    }
}
