<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'start_date',
        'end_date',
        'renewal_id',
        'payment_method',
        'is_trial',
        'cancelled_at',
    ];

    // A subscription belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);   
    }
    // A subscription belongs to a plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);   
    }
    // A subscription belongs to a payment
    public function payments()
    {
        return $this->belongsTo(Payment::class);
    }

    
}
