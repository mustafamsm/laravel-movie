<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SeasonController extends Controller
{
    public function index(TvShow $tvShow){



        $perPage = request()->input('perPage') ?: 5;

        return Inertia::render('TvShows/Seasons/Index', [
            'seasons' => Season::query()
                ->where('tv_show_id', $tvShow->id)
                ->when(request()->input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->paginate($perPage)
                ->withQueryString(),
            'filters' => request()->only(['search', 'perPage']),
            'tvShow' => $tvShow,
        ]);

    }

    public function store(TvShow $tvShow,Request $request)
    {
        $season = $tvShow->seasons()->where('season_number', $request->seasonNumber)->exists();
        if ($season) {
            return Redirect::back()->with('flash.banner', 'Season Exists.');
        }

        $tmdb_season = Http::asJson()->get(config('services.tmdb.endpoint') . 'tv/' .$tvShow->tmdb_id . '/season/' . $request->seasonNumber . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');
        if ($tmdb_season->successful()) {
            Season::create([
                'tv_show_id' => $tvShow->id,
                'tmdb_id' => $tmdb_season['id'],
                'name'    => $tmdb_season['name'],
                'poster_path' => $tmdb_season['poster_path'],
                'season_number' => $tmdb_season['season_number']
            ]);
            return Redirect::back()->with('flash.banner', 'Season created.');
        } else {
            return Redirect::back()->with('flash.banner', 'Api error.');
        }
    }
}
