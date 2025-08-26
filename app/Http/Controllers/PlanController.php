<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;


class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$plans = Plan::orderBy('id')->get();
        $plans = Plan::all();

    return response()->json([
        'success' => true,
        'data' => $plans
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|string|in:monthly,yearly',
            'features' => 'nullable|string', 
            'trial_period_days' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $plan = Plan::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'features' => $request->features,
            'trial_period_days' => $request->trial_period_days,
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Plan created successfully',
            'data' => $plan
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find the plan by id
        $plan = Plan::find($id);
        //if plan not found, return error response
        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Plan not found',
            ], 404);
        }
        //return the plan data
        return response()->json([
            'success' => true,
            'data' => $plan,
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
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'billing_cycle' => 'sometimes|required|string|in:monthly,yearly',
            'features' => 'nullable|string', // expecting an array
            'trial_period_days' => 'sometimes|required|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $plan = Plan::find($id);
        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Plan not found',
            ], 404);
        }

        $plan->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Plan updated successfully',
            'data' => $plan
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find the festival by id
        $plan = Plan::find($id);
        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'plan not found',
            ], 404);    

        //delete the festival
        } else {
            $plan->delete();
            return response()->json([
                'success' => true,
                'message' => 'plan deleted successfully',
            ], 200);    
    }
    }


    /**
     * Get all active plans.
     */
    public function getActivePlans()
    {
        $activePlans = Plan::where('is_active', true)->get();
        return response()->json([
            'success' => true,
            'data' => $activePlans
        ]); 
    }   
    
    


}
    