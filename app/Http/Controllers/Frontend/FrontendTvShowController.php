<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Season;
use App\Models\TvShow;
use App\Models\Episode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Movie;

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
        $latests=Movie::orderBy('created_at','desc')->take(9)->get();

        return Inertia::render('Frontend/TvShows/Show',[
            'tvShow' => $tvShow,
            'seasons' => $tvShow->seasons()->orderBy('created_at','desc')->get(),
            'latests'=>$latests
        ]);
    }

    public function seasonShow(TvShow $tvShow,Season $season)
    {
        $latests=Movie::orderBy('created_at','desc')->take(9)->get();

        return Inertia::render('Frontend/TvShows/Seasons/Show',[
            'tvShow' => $tvShow,
            'season' => $season,
            'episodes' => $season->episodes()->orderBy('created_at','desc')->get(),
            'latests'=>$latests
        ]);
    }

    public function showEpisode(Episode $episode)
    {
        $latests = Episode::with('season')->latest()->take(12)->get();
 
        return Inertia::render('Frontend/Episodes/Show',[
            'episode' => $episode,
            'season' => $episode->season,
            'latests'=>$latests

        ]);
    }

}
