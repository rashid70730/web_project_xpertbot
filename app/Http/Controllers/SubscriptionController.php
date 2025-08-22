<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::all();
        return response()->json([
            'success' => true,
            'data' => $subscriptions,
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
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|string|in:active,cancelled,expired',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'renewal_id' => 'nullable|exists:subscriptions,id',
            'payment_method' => 'required|string|max:255',
            'is_trial' => 'nullable|boolean',
            
        ]);

        $subscription = Subscription::create([
            'user_id' => $request->user_id,
            'plan_id' => $request->plan_id,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'renewal_id' => $request->renewal_id,
            'payment_method' => $request->payment_method,
            'is_trial' => $request->is_trial,
           
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully',
            'data' => $subscription
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $subscription,
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
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'plan_id' => 'sometimes|required|exists:plans,id',
            'status' => 'sometimes|required|string|in:active,cancelled,expired',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'renewal_id' => 'nullable|exists:subscriptions,id',
            'payment_method' => 'sometimes|required|string|max:255',
            
            
            // Add other fields as necessary
        ]);

        $subscription->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Subscription updated successfully',
            'data' => $subscription
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        $subscription->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subscription deleted successfully',
        ]);
    }
    /**
     * Get all active subscriptions for a user.
     */
    public function getUserSubscriptions($userId)
    {
        $subscriptions = Subscription::where('user_id', $userId)    
            ->where('status', 'active')
            ->with('plan')
            ->get();    

        if ($subscriptions->isEmpty()) {
            return response()->json(['message' => 'No active subscriptions found for this user'],       
            404);
        }
        return response()->json([
            'success' => true,
            'data' => $subscriptions,
        ]); 
    }

    /**
     * Get all subscriptions for a specific plan.
     */
    public function getPlanSubscriptions($planId)
    {
        $subscriptions = Subscription::where('plan_id', $planId)
            ->with('user')
            ->get();
        if ($subscriptions->isEmpty()) {
            return response()->json(['message' => 'No subscriptions found for this plan'], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $subscriptions,
        ]);
    }
    /**
     * Retrieve all active subscriptions for the specified user, including their plan details.
     */
    public function getActiveSubscriptions()
    {
        $activeSubscriptions = Subscription::where('status', 'active')
            ->with('user', 'plan')
            ->get();

            if ($activeSubscriptions->isEmpty()) {
                return response()->json(['message' => 'No active subscriptions found'], 404);
            }

        return response()->json([
            'success' => true,
            'data' => $activeSubscriptions,
        ]);
    }

    
}


        
    