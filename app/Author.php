<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Author extends Model
{
    use Searchable;

    protected $fillable = [
        'name', 'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($author) {
            $author->books->each->delete();
        });
    }

    public function books()
    {
        return $this->hasMany('App\Book');
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $unsearchableFields = ['id', 'updated_at', 'created_at'];

        foreach ($unsearchableFields as $field) {
            unset($array[$field]);
        }

        return $array;
    }
}
