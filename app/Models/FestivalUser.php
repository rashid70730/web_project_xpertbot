<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FestivalUser extends Model
{
    protected $table = 'festival_user';

    protected $fillable = [
        'festival_id',
        'user_id',
        'role',
    ];

    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
