<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Movie;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\TvShow;

class SearchController extends Controller
{
    public function search(Request $request){
        $searchResults=(new Search())
        ->registerModel(Movie::class,'title')
        ->registerModel(TvShow::class,'name')
        ->registerModel(Episode::class,'name')
        ->search($request->search);

        return response()->json($searchResults);
        
    }
}
