<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;

class FrontendTvShowController extends Controller
{
    public function index()
    {
        // return Inertia::render('Frontend/Movies/Index');
    }
    public function show(TvShow $tvShow)
    {
        // return Inertia::render('Frontend/Movies/Show');
    }

    public function seasonShow(TvShow $tvShow,Season $season)
    {
        // return Inertia::render('Frontend/Movies/Show');
    }

    public function showEpisode(Episode $episode)
    {
        // return Inertia::render('Frontend/Movies/Show');
    }

}
