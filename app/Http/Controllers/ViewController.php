<?php

namespace App\Http\Controllers;

use App\Models\View;
use Illuminate\Http\Request;


class ViewController extends Controller
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
            'user_id' => 'required|exists:users,id',
            'film_id' => 'required|exists:films,id',
        ]);

        $view = View::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $view,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(View $view)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(View $view)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, View $view)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(View $view)
    {
        //
    }

    /**
     * Get views by user ID.
     */
    public function getViewsByUserId($userId)
    {
        $views = View::where('user_id', $userId)->get();    
        if ($views->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No views found for this user',
            ], 404);
        }
        
    }
    /**
     * Get views by film ID.
     */
    public function getViewsByFilmId($filmId)
    {
        $views = View::where('film_id', $filmId)->get();
        if ($views->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No views found for this film',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $views,
        ]); 
    }
    /**
     * Get views by festival ID.
     */
    public function getViewsByFestivalId($festivalId)
    {
        $views = View::where('festival_id', $festivalId)->get();
        return response()->json([
            'success' => true,
            'data' => $views,
        ]); 
    }
        /**
         * Get views by plan ID.
         */
        public function getViewsByPlanId($planId)
        {
            $views = View::where('plan_id', $planId)->get();
            if($views->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No views found for this plan',
                ], 404);
            }
           
        }

    /**
     * Get views by subscription ID.
     */
    public function getViewsBySubscriptionId($subscriptionId)
    {
        $views = View::where('subscription_id', $subscriptionId)->get();
        return response()->json([
            'success' => true,
            'data' => $views,
        ]);     
    }
    /**
     * Get views by payment ID.
     */
    public function getViewsByPaymentId($paymentId)
    {
        $views = View::where('payment_id', $paymentId)->get();
        return response()->json([
            'success' => true,      
            'data' => $views,
        ]);
    }


}
