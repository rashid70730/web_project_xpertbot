<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 


class Festival extends Model
{
    use HasFactory, SoftDeletes; // 👈 add SoftDeletes trait


    protected $fillable = [
        'name',
        'location',
        'country',
        'duration',
        'submission_open',
        'submission_closed',
    ];
    // A festival can have many users
    public function users()
    {
        return $this->belongsToMany(User::class, 'festival_user')
                    ->withPivot('role', 'status')
                    ->withTimestamps();
    }

    // A festival can have many films
    public function films()
    {
        return $this->belongsToMany(Film::class, 'festival_film')
                    ->withPivot('status', 'decision_date', 'comments')
                    ->withTimestamps();
    }
}
