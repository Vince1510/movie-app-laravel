<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    //door fillable worden alleen deze velden toegestaan
    protected $fillable = [
        'tmdb_id',
        'title',
        'overview',
        'poster_path',
        'genre',
        'release_date',
    ];

    // 1 film kan door meerdere mensen favoriet gemaakt worden
    // en 1 gebruiker kan meerdere films aan favorieten toevoegen
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'movie_user');
    }
}
