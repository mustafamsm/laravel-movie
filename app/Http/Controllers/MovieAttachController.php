<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Cast;
use App\Models\Download;
use Inertia\Inertia;
use App\Models\Movie;
use App\Models\TrailerUrl;
use Illuminate\Http\Request;

class MovieAttachController extends Controller
{
    public function index(Movie $movie)
    {
        return Inertia::render('Movies/Attach', [
            'movie' => $movie,
            'trailers' => $movie->trailers,
            'downloads' => $movie->downloads,
            'casts' => Cast::all('id', 'name'),
            'tags' => Tag::all('id', 'tag_name'),
            'movieCasts' => $movie->casts,
            'movieTags' => $movie->tags,
            

        ]);
    }

    public function addTrailer(Movie $movie, Request $request)
    {

        $movie->trailers()->create($request->validate([
            'name' => 'required',
            'embed_html' => 'required'
        ]));
        return redirect()->back()->with('flash.banner', 'Trailer Added .');
    }

    public function destroyTrailer(TrailerUrl $trailer_url)
    {
        $trailer_url->delete();
        return redirect()->back()->with('flash.banner', 'Trailer Deleted .');
    }

    public function addCast(Request $request, Movie $movie)
    {
        $casts = $request->casts;
        $casts_ids = collect($casts)->pluck('id');

        $movie->casts()->sync($casts_ids);
        return redirect()->back()->with('flash.banner', 'Casts Attached .');
    }
    public function addTag(Request $request, Movie $movie)
    {
        $tags = $request->tags;
        $tags_ids = collect($tags)->pluck('id');

        $movie->tags()->sync($tags_ids);
        return redirect()->back()->with('flash.banner', 'Tags Attached .');
    }
    public function addDownload(Movie $movie, Request $request){

        $movie->downloads()->create($request->validate([
            'name' => 'required',
            'web_url' => 'required'
        ]));
        return redirect()->back()->with('flash.banner', 'Download Added .');
    }
    public function destroyDownload(Download $download)
    {
        $download->delete();
        return redirect()->back()->with('flash.banner', 'Download Deleted .');
    }
}
