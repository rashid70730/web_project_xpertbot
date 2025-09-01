<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Festival;


class FestivalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $festivals = Festival::all();
        return response()->json([
            'success' => true,
            'data' => $festivals,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'country' => 'required|string|max:255',
        'duration' => 'required|string|max:255', 
        'submission_open' => 'nullable|date',
        'submission_closed' => 'nullable|date',
    ]);

    $festival = Festival::create([
        'name' => $request->name,
        'location' => $request->location,
        'country' => $request->country, 
        'duration' => $request->duration,
        'submission_open' => $request->submission_open,
        'submission_closed' => $request->submission_closed,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Festival created successfully',
        'data' => $festival,
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find the festival by id
        $festival = Festival::find($id);

        //if festival not found, return error response
        if (!$festival) {
            return response()->json([
                'success' => false,
                'message' => 'Festival not found'.$id,
            ], 404);
        }
        //return the festival data
        return response()->json([
            'success' => true,
            'data' => $festival,
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
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255'. $id,
            'country' => 'required|string|max:255',
            'duration' => 'required|string|max:255', 
            'submission_open' => 'nullable|date',
            'submission_closed' => 'nullable|date',
        ]);

        //find the festival by id
        $festival = Festival::find($id);
        //if festival not found, return error response
        if (!$festival) {
            return response()->json([
                'success' => false,
                'message' => 'Festival not found',
            ], 404);
        }
        //update the festival with the request data
        $festival->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Festival updated successfully',
            'data' => $festival,
        ]);
    }

     // Soft delete a festival
     public function destroy($id)
     {
         $festival = Festival::find($id);
 
         if (!$festival) {
             return response()->json([
                 'success' => false,
                 'message' => 'Festival not found.'
             ], 404);
         }
 
         $festival->delete(); // soft delete
 
         return response()->json([
             'success' => true,
             'message' => 'Festival deleted (soft delete applied).'
         ]);
     }
 
     // Restore a soft-deleted festival
     public function restore($id)
     {
         $festival = Festival::withTrashed()->find($id);
 
         if (!$festival) {
             return response()->json([
                 'success' => false,
                 'message' => 'Festival not found.'
             ], 404);
         }
 
         if (!$festival->trashed()) {
             return response()->json([
                 'success' => false,
                 'message' => 'Festival is not deleted.'
             ], 400);
         }
 
         $festival->restore();
 
         return response()->json([
             'success' => true,
             'message' => 'Festival restored successfully.'
         ]);
     }
 
     // Permanently delete a festival
     public function forceDelete($id)
     {
         $festival = Festival::withTrashed()->find($id);
 
         if (!$festival) {
             return response()->json([
                 'success' => false,
                 'message' => 'Festival not found.'
             ], 404);
         }
 
         $festival->forceDelete(); // permanently delete
 
         return response()->json([
             'success' => true,
             'message' => 'Festival permanently deleted.'
         ]);
     }
}


