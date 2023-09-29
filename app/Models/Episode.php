<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model  implements \Spatie\Searchable\Searchable
{
    use HasFactory;
    protected $fillable = ['tmdb_id', 'name', 'slug', 'overview', 'season_id', 'episode_number', 'is_public'];
    public function getSearchResult(): SearchResult
    {
        $url = route('episodes.show', $this->slug);
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

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
