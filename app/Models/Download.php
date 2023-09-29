<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'web_url',
        'download_count',
        'downloadable_id',
        'downloadable_type',
        
    ];
}
