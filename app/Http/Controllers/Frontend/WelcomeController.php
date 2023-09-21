<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\TvShow;

class WelcomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with('genres')->orderBy('updated_at','desc')->take(12)->get();
        $series=TvShow::withCount('seasons')->orderBy('created_at','desc')->take(12)->get();
        $episodes=Episode::with('season')->orderBy('created_at','desc')->take(12)->get();
        return Inertia::render('Welcome',[
            'movies'=>$movies,
            'tvShows'=>$series,
            'episodes'=>$episodes

            
        ]);
    }
}
