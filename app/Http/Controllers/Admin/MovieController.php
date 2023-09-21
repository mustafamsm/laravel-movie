<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class MovieController extends Controller
{
  public function index()
  {

    $perPage = request()->input('perPage') ?: 5;

    return Inertia::render('Movies/Index', [
      'movies' => Movie::query()
        ->when(request()->input('search'), function ($query, $search) {
          $query->where('title', 'like', "%{$search}%");
        })->when(request()->input('column'), function ($query, $column) {
          $query->orderBy($column, request()->input('direction', 'desc'));
        })
        ->paginate($perPage)
        ->withQueryString(),
      'filters' => request()->only(['search', 'perPage','column','direction'])
    ]);
  }

  public function store(Request $request)
  {
    $movie = Movie::where('tmdb_id', $request->movieTMDBId)->exists();
    if ($movie) {
      return Redirect::back()->with('flash.banner', 'Movie Exists.');
    }
    $apiMovie = Http::asJson()->get(config('services.tmdb.endpoint') . 'movie/' . $request->movieTMDBId . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');

    if ($apiMovie->successful()) {

      $created_movie = Movie::create([
        'tmdb_id' => $apiMovie['id'],
        'title' => $apiMovie['title'],
        'runtime' => $apiMovie['runtime'],
        'rating' => $apiMovie['vote_average'],
        'release_date' => $apiMovie['release_date'],
        'lang' => $apiMovie['original_language'],
        'video_format' => 'HD',
        'is_public' => false,
        'overview' => $apiMovie['overview'],
        'poster_path' => $apiMovie['poster_path'],
        'backdrop_path' => $apiMovie['backdrop_path']
      ]);
      //get the movie genres
      $tmdb_genres = $apiMovie['genres'];
      //extract its id's 
      $tmdb_genres_ids = collect($tmdb_genres)->pluck('id');
      //select from db using the above id's
      $genres = Genre::whereIn('tmdb_id', $tmdb_genres_ids)->get();
      //attach the move and genre to pivote table
      $created_movie->genres()->attach($genres);
      return Redirect::back()->with('flash.banner', 'Movie create.');
    } else {
      return Redirect::back()->with('flash.banner', 'Api Error.');
    }
  }

  public function edit(Movie $movie)
  {
    return Inertia::render('Movies/Edit', ['movie' => $movie]);
  }
  public function update(Movie $movie, Request $request)
  {
    $request->validate([
      'title' => 'required',
      'poster_path' => 'required',
      'runtime' => 'required',
      'lang' => 'required',
      'video_format' => 'required',
      'rating' => 'required',
      'backdrop_path' => 'required',
      'overview' => 'required',
      'is_public' => 'required'
    ]);

    $movie->update($request->all());
    return Redirect::route('admin.movies.index')->with('flash.banner', 'Movie Updated.');
  }

  public function destroy(Movie $movie)
  {
    //sync changes 
    $movie->genres()->sync([]);
    $movie->delete();
    return Redirect::route('admin.movies.index')->with('flash.banner', 'Movie Deleted.')->with('flash.bannerStyle', 'danger');
  }
}
