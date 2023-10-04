<?php

namespace App\Http\Controllers\Admin;


use App\Models\Genre;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:create genres')->only('store');
        $this->middleware('can:edit genres')->only('update','edit');
        $this->middleware('can:delete genres')->only('destroy');
        $this->middleware('can:show genres')->only('index');
        
    }
    public function index()
  {
      $perPage = request()->input('perPage') ?: 5;

      return Inertia::render('Genres/Index', [
          'genres' => Genre::query()
              ->when(request()->input('search'), function ($query, $search) {
                  $query->where('title', 'like', "%{$search}%");
              })
              ->paginate($perPage)
              ->withQueryString(),
          'filters' => request()->only(['search', 'perPage']),
        
      ]);
  }

  public function store(Request $request){
      $tmdb_genres = Http::get(config('services.tmdb.endpoint') . 'genre/movie/list?api_key=' . config('services.tmdb.secret') . '&language=en-US');
      if ($tmdb_genres->successful()) {
          $tmdb_genres_json = $tmdb_genres->json();
          foreach($tmdb_genres_json as $single_tmdb_genre){
              foreach ($single_tmdb_genre as $tgenre){
                  $genre = Genre::where('tmdb_id', $tgenre['id'])->first();
                  if (!$genre) {
                      Genre::create([
                          'tmdb_id' => $tgenre['id'],
                          'title' => $tgenre['name']
                      ]);
                  }
              }
          }
          return Redirect::back()->with('flash.banner', 'genre created.');
      }
      return Redirect::back()->with('flash.banner', 'Api Error.');
  }
  public function edit(Genre $genre){
        return Inertia::render('Genres/Edit',['genre'=>$genre]);
  }
  public function update(Genre $genre,Request $request){
        $request->validate([
            'title'=>'required'
        ]);
        $genre->update([
            'title'=>$request->title
        ]);
      return Redirect::route('admin.genres.index')->with('flash.banner', 'Genre Updated!');

  }
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return Redirect::back()->with('flash.banner', 'Genre Deleted.');
    }
}
