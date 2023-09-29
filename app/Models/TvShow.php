<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TvShow extends Model implements \Spatie\Searchable\Searchable
{
    use HasFactory;
    protected $fillable = ['tmdb_id', 'name', 'slug', 'poster_path', 'created_year'];

    public function getSearchResult(): SearchResult
    {
        $url = route('tvShows.show', $this->slug);
        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }
}
