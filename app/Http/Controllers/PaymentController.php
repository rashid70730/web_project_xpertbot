<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment; 
use Stripe\Charge;
use App\Services\PaymentService;



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

   

    // public function pay(Request $request)
    // {
    // Stripe::setApiKey(env('STRIPE_SECRET'));

    // $charge = Charge::create([
    //     'amount' => 50,
    //     'currency' => 'usd',
    //     'source' => $request->stripeToken,
    //     'description' => 'Film festival ticket',
    // ]);

    // return response()->json($charge);
    // }


    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1|max:100000',
            'currency' => 'required|string|in:usd,eur,aud',
        ]);
    
        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => $request->currency,
                    'unit_amount' => $request->amount,
                    'product_data' => [
                        'name' => 'Film Purchase',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/success'),
            'cancel_url' => url('/cancel'),
        ]);
    
        return response()->json($session);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'film_id' => 'required|exists:films,id',
        'type'    => 'required|string|in:subscription,pay-per-view,donation',
        'amount'  => 'required|numeric|min:1|max:10000',
    ]);

    $payment = Payment::create([
        'user_id' => $validated['user_id'],
        'film_id' => $validated['film_id'],
        'type'    => $validated['type'],
        'amount'  => $validated['amount'],
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Payment created successfully',
        'data'    => $payment
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
