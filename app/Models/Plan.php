<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        
        'name',
        'description',
        'price',
        'billing_cycle', // e.g., monthly, yearly
        'features', // JSON or serialized array of features
        'trial_period_days', //
        'is_active', //
    ];
    // A plan can have many users
    public function users()
    {
        return $this->hasMany(User::class); 
    }

    // A plan can have many subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class); 
    }




    
}
