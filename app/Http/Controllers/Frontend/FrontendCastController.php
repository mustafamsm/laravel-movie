<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cast;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendCastController extends Controller
{
    public function index()
    {
        $casts = Cast::orderBy('updated_at', 'desc')->paginate(10);
        return Inertia::render('Frontend/Casts/Index', [
            'casts' => $casts
        ]);
    }
    public function show(Cast $cast)
    {
        $movies = $cast->movies;
        return Inertia::render('Frontend/Casts/Show', [
            'cast' => $cast,
            'movies' => $movies,
            

        ]);
    }
}
