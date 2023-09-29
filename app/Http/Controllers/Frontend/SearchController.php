<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Movie;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request){
        $searchResults=(new Search())
        ->registerModel(Movie::class,'title')
        ->registerModel(Movie::class,'title')
        ->registerModel(Movie::class,'title')
        ->search($request->search);

        return response()->json($searchResults);
        
    }
}
