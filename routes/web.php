<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-stripe', function () {
    return env('STRIPE_SECRET', 'not found');
});