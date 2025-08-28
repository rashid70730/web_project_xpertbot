<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentService {
    public function createCheckoutSession($amount, $currency = 'usd') {
        Stripe::setApiKey(config('services.stripe.secret'));

        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => ['name' => 'Film Access'],
                    'unit_amount' => $amount * 100, // cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/payment/success'),
            'cancel_url' => url('/payment/cancel'),
        ]);
    }
}