<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 


class Film extends Model
{
    use HasFactory, SoftDeletes; 



    protected $fillable = [
        'user_id', // Assuming films are linked to users
        'title',
        'description',
        'type',
        'distribution_phase',
        'status',
        'video_url',
        'thumbnail_url',
    ];
 
     // A film can be in many festivals
     public function festivals()
     {
         return $this->belongsToMany(Festival::class, 'festival_film')
                     ->withPivot('status', 'decision_date', 'comments')
                     ->withTimestamps();
     }

     // A film belongs to one user
     public function user()
        {
            return $this->belongsTo(User::class);
        }
}
