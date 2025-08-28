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

