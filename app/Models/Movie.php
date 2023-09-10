<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'summary',
        'cover_image',
        'genres',
        'author',
        'tags',
        'imdb_rating',
        'pdf_download_link'
    ];

    public function comments() :HasMany
    {
        return $this->hasMany(Comment::class);
    }
}

