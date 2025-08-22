<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Festival;
use App\Models\Film;
use App\Models\FestivalFilm;



class FestivalFilm extends Model
{
    protected $table = 'festival_film';
    protected $fillable = [
        'festival_id',
        'film_id',
        'status',
        'decision_date',
        'comments',
    ];

    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
