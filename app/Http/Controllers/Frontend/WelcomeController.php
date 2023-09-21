<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\TvShow;

class WelcomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome',[
            'movies'=>Movie::with('genres')->get(),
            'tvShows'=>TvShow::all(),

            
        ]);
    }
}
