<?php

namespace App\Http\Controllers\Admin;

 
use App\Models\Tag;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
  public function __construct()
  {
    $this->middleware('can:create tags')->only('create','store');
    $this->middleware('can:edit tags')->only('update', 'edit');
    $this->middleware('can:delete tags')->only('destroy');
    $this->middleware('can:show tags')->only('index');
    
  }
    public function index()
  {
    
    return Inertia::render('Tags/Index',[
      'tags' => Tag::query()
      ->when(request()->search,function($q){
        $q->where('tag_name','like',"%".request()->search."%");
      })
      
      ->paginate(request()->perPage ?? 5  )
      ->withQueryString(),
      'filters' => request()->only(['search','perPage']),
       
     
    ]);
  }

  public function create()
  {
    return Inertia::render('Tags/Create');
  }
  public function store(Request $request)
  {
 
    $request->validate([
      'tagName' => 'required|unique:tags,tag_name'
    ]);

    $tag = Tag::create([
      'tag_name' => $request->tagName,
      'slug' => Str::slug($request->tagName)
    ]);

   return to_route('admin.tags.index')->with('flash.banner', 'Tag Created Successfully');
  }

  public function edit(Tag $tag){
    return Inertia::render('Tags/Edit',[
      'tag' => $tag
    ]);
  }
  public function update(Request $request,Tag $tag)
  {
    $request->validate([
      'tagName' => 'required|unique:tags,tag_name,'.$tag->id
    ]);

    $tag->update([
      'tag_name' => $request->tagName,
      'slug' => Str::slug($request->tagName)
    ]);

   return to_route('admin.tags.index')->with('flash.banner', 'Tag Updated Successfully');
  }
  public function destroy(Tag $tag)
  {
    $tag->delete();
    return to_route('admin.tags.index')->with('flash.banner', 'Tag Deleted Successfully');
  }
}
