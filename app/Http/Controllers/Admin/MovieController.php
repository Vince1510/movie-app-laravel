<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        //data halen vanuit Movie.php
        $movies = Movie::latest()->get();

        //doorgegeven aan de view
        return view('admin.index', compact('movies'));
    }
}