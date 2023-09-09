<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CastController extends Controller
{
    public function index()
    {
        $perPage = request()->input('perPage') ?: 5;

        return Inertia::render('Casts/Index', [
            'casts' => Cast::query()
                ->when(request()->input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->paginate($perPage)
                ->withQueryString(),
            'filters' => request()->only(['search', 'perPage'])
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'castTMDBId' => 'required',
        ]);

        $cast = Cast::where('tmdb_id', $request->castTMDBId)->first();
        if ($cast) {
            return Redirect::back()->with('flash.banner', 'Cast already exists');
        }
        $tmdb_cast = Http::asJson()->get(config('services.tmdb.endpoint') . 'person/' . $request->castTMDBId . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');

        if ($tmdb_cast->successful()) {
            Cast::create([
                'tmdb_id' => $tmdb_cast['id'],
                'name' => $tmdb_cast['name'],
                'slug' => Str::slug($tmdb_cast['name']),
                'poster_path' => $tmdb_cast['profile_path'],
            ]);
            return Redirect::back()->with('flash.banner', 'Cast added successfully');
        } else {
            return Redirect::back()->with('flash.banner', 'Cast not found');
        }


    }
    public function edit(Cast $cast)
    {
        return Inertia::render('Casts/Edit', [
            'cast' => $cast,
        ]);
    }
    public function update(Cast $cast,Request $request){
        $request->validate([
            'name' => 'required',

            'poster_path' => 'required',
        ]);
        $cast->update([
            'name' => $request->name,

            'poster_path' => $request->poster_path,
        ]);
        return Redirect::route('admin.casts.index')->with('flash.banner', 'Cast updated successfully');
    }
    public function destroy(Cast $cast)
    {
        $cast->delete();
        return Redirect::back()->with('flash.banner', 'Cast Deleted.');
    }
}
