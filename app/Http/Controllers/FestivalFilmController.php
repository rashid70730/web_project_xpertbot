<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FestivalFilm;
use App\Models\Festival;
use App\Models\Film;

class FestivalFilmController extends Controller
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
            'film_id' => 'required|exists:films,id',
            'status' => 'required|in:pending,accepted,rejected',
            'decision_date' => 'nullable|date',
            'comments' => 'nullable|string|max:500',
        ]);

        $festivalfilm = FestivalFilm::create($validated);

        return response()->json($festivalfilm, 201);
        
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


    
    public function getFilmsByFestival($festivalId)
    {
        $festivalFilms = FestivalFilm::where('festival_id', $festivalId)->with('film')->get();  
        if ($festivalFilms->isEmpty()) {
            return response()->json(['message' => 'No films found for this festival'], 404);
        }       
        return response()->json([
            'success' => true,
            'data' => $festivalFilms,
        ], 200);
    } 

    /**
     * Show all films in a festival.
     */
    public function showFilms($festivalId)
    {   
    // Get all films in a festival
    $festival = Festival::find(1);
    $films = $festival->films;
        return response()->json($films);
    }
    /**
     * Get festivals by film ID.
     */
    public function getFestivalsByFilm($filmId)
    {
        $festivalFilms = FestivalFilm::where('film_id', $filmId)->with('festival')->get();
        if ($festivalFilms->isEmpty()) {
            return response()->json(['message' => 'No festivals found for this film'], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $festivalFilms,
        ], 200);
    }

     /**
     * Get the count of films in a festival.
     */
    public function getCountOfFilmByFestival($id)
    {
        $festival = Festival::find($id);
        if (!$festival) {
            return response()->json(['message' => 'Festival not found'], 404);
        }

        $filmCount = $festival->films()->count();

        return response()->json([
            'festival_id' => $id,
            'film_count' => $filmCount,
        ]);
    }

    
}

