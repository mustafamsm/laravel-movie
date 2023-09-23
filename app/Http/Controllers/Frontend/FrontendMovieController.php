<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendMovieController extends Controller
{
    public function index()
    {
        $movies=Movie::with('genres')->orderBy('created_at','desc')->paginate(15);
         
        return Inertia::render('Frontend/Movies/Index',[
            'movies' => $movies
        ]);
    }
    public function show(Movie $movie)
    {
        $latests=Movie::with('genres')->orderBy('created_at','desc')->take(9)->get();
        
        return Inertia::render('Frontend/Movies/Show',[
           'movie'=>$movie,
            'latests'=>$latests ,
            'movieGenres'=>$movie->genres,
            'casts'=>$movie->casts,
            'tags'=>$movie->tags,
            'trailers'=>$movie->trailers,
        ]);
    }
}
