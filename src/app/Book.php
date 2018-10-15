<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    const DEFAULT_IMAGE_URL = '/images/no_image.jpg';

    protected $fillable = [
        'title', 'description', 'author_id', 'isbn', 'year', 'pages_count', 'price'
    ];

    public static function getLast($count=10)
    {
        return self::orderByDesc('created_at')->take(10)->get();
    }

    public function getImageAttribute($value)
    {
        return $value ?: self::DEFAULT_IMAGE_URL;
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
