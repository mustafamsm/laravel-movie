<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Season;
use App\Models\TvShow;
use App\Models\Episode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendTvShowController extends Controller
{
    public function index()
    {
        $tvshows=TvShow::orderBy('created_at','desc')->paginate(15);
        return Inertia::render('Frontend/TvShows/Index',[
            'tvShows' => $tvshows
        ]);
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
