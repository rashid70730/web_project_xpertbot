<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment; // Assuming you have a Payment model

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment =  Payment::all();
        return response()->json([
            'success'=> true,
            'data' => $payment,
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
            'film_id' => 'required|exists:films,id',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            
            
        ]);

        $payment = Payment::create([
            'user_id' => $request->user_id,
            'film_id' => $request->film_id,
            'type' => $request->type,
            'amount' => $request->amount,
            
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment created successfully',
            'data' => $payment
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $payment,
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
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found',
            ], 404);
        }

        $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'film_id' => 'sometimes|exists:films,id',
            'type' => 'sometimes|string',
            'amount' => 'sometimes|numeric|min:0',
        ]);

        $payment->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Payment updated successfully',
            'data' => $payment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found',
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted successfully',
        ]);
    }

    /**
     * Get all payments for a specific user.
     */
    public function getUserPayments($userId)
    {   
        $payments = Payment::where('user_id', $userId)->get();
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No payments found for this user'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $payments,
        ], 200);    
    }       
}   
