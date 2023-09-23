<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendGenreController extends Controller
{
    public function show(Genre $genre){
        $movies = $genre->movies()->paginate(12);

        return Inertia::render('Frontend/Genres/Index', [
            'genre' => $genre,
            'movies' => $movies
        ]);
    }
}
