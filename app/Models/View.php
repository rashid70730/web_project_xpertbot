<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'user_id',
        'film_id',
    ];

    /**
     * Get the user that owns the view.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the film that was viewed.
     */
    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
