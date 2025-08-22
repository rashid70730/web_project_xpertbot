<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = false; // 👈 Disable auto timestamps
    protected $fillable = [
        'user_id',
        'film_id',
        'type',
        'amount',
    ];

    // A payment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);   
    }

    // A payment can br linked to a subscription
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
    
}
