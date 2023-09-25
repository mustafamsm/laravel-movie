<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Tag;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendTagController extends Controller
{
    public function show(Tag $tag)
    {
        return Inertia::render('Frontend/Tags/Index',[
            'tag'=>$tag,
            'movies'=>$tag->movies()->paginate(12)
             
         ]);
    }
}
