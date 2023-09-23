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
    public function show()
    {
        // return Inertia::render('Frontend/Movies/Show');
    }
}
