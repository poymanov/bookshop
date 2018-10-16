<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
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
}
