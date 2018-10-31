<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Book extends Model
{
    use Searchable;

    const DEFAULT_IMAGE_URL = '/images/no_image.jpg';

    protected $fillable = [
        'title', 'description', 'author_id', 'isbn', 'year', 'pages_count', 'price', 'image'
    ];

    public static function getLast($count = 10)
    {
        return self::orderByDesc('created_at')->take(10)->get();
    }

    public function getImageAttribute($value)
    {
        return asset($value ? '/storage/'.$value : self::DEFAULT_IMAGE_URL);
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $unsearchableFields = ['id', 'image', 'pages_count', 'created_at', 'updated_at', 'author_id'];

        foreach ($unsearchableFields as $field) {
            unset($array[$field]);
        }

        return $array;
    }
}
