<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Http\Requests\StoreFilmRequest;
use App\Notifications\FilmApprovedNotification;


class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Logic to list all films
        $films = Film::all();
        return response()->json([
            'success' => true,
            'data' => $films,
        ]);

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
    /*public function store(Request $request)
    {
        $request->validate([

            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:255',
            'distribution_phase' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'video_url' => 'required|url',
            'thumbnail_url' => 'url',
            
        ]);

        $film = Film::create([
            'user_id' => $request->user()->id, // Assuming the user is authenticated
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'distribution_phase' => $request->distribution_phase,
            'status' => $request->status,
            'video_url' => $request->video_url,
            'thumbnail_url' => $request->thumbnail_url,
            

            
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Film created successfully',
            'data' => $film,
        ], 201);
    }*/

    public function store(StoreFilmRequest $request)
{
    $film = Film::create(array_merge(
        $request->validated(),
        ['user_id' => auth()->id()]
    ));

    return response()->json(['data' => $film], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find the film by id
        $film = Film::find($id);
        //if film not found, return error response
        if (!$film) {
            return response()->json([
                'success' => false,
                'message' => 'film not found'.$id,
            ], 404);
        }
        //return the festival data
        return response()->json([
            'success' => true,
            'data' => $film,
        ]);
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
    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'title' => 'sometimes|required|string|max:255',
    //         'description' => 'sometimes|required|string',
    //         'type' => 'sometimes|required|string|max:255',
    //         'distribution_phase' => 'sometimes|required|string|max:255',
    //         'status' => 'sometimes|required|string|max:255',
    //         'video_url' => 'sometimes|required|url',
    //         'thumbnail_url' => 'sometimes|url',
    //     ]);
    //     //find the festival by id
    //     $film = Film::find($id);
    //     //if not found,return a message 
    //     if (!$film) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Film not found',
    //         ], 404);
    //     }
    //     //update the film with the request data
    //     $film->update($request->all());

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Film updated successfully',
    //         'data' => $film,
    //     ]);
        
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find the film by id
        $film = Film::find($id);
        if (!$film) {
            return response()->json([
                'success' => false,
                'message' => 'film not found',
            ], 404);    

        //delete the film
        } else {
            $film->delete();
            return response()->json([
                'success' => true,
                'message' => 'film deleted successfully',
            ], 200);    
    }
        
    }


    public function accepted (Film $film)
    {
        // Only allow approving if film is pending
        if ($film->status === 'pending') {
            $film->status = 'accepted';
            $film->save();

            // Notify the owner
            $film->user->notify(new FilmApprovedNotification($film));

            return response()->json([
                'message' => 'Film accepted successfully',
                'film' => $film
            ]);
        }

        return response()->json([
            'message' => 'Film cannot be accepted. Current status: ' . $film->status,
            'film' => $film
        ], 400);
    }



    // Update a film
    public function update(Request $request, Film $film)
    {
        // Authorize using the policy
        $this->authorize('update', $film);

        // Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // other fields
        ]);

        // Update the film
        $film->update($request->all());

        return response()->json([
            'message' => 'Film updated successfully',
            'film' => $film
        ]);
    }





}
