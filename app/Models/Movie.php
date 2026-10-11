<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'tmdb_id',
        'title',
        'overview',
        'poster_path',
        'genre',
        'release_date',
    ];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'movie_user');
    }
}