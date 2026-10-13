<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


// hier komt $movies vandaan
class Movie extends Model
{
    protected $guarded = [
        'tmdb_id',
        'title',
        'overview',
        'poster_path',
        'genre',
        'release_date',
    ];


    // 1 fim kan dus door meerdere gebruikers worden opgeslagen als favoriet
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'movie_user');
    }
}