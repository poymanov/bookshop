<?php

namespace App\Services;

use Image;
use App\Book;
use Illuminate\Http\Request;

class BooksService extends BaseService
{
    private $showRouteName = 'api.books.show';

    const VALIDATION_RULES = [
        'title' => 'required',
        'description' => 'required',
        'author_id' => 'required|exists:authors,id',
        'isbn' => 'required',
        'year' => 'required',
        'pages_count' => 'required',
        'price' => 'required',
        'cover' => 'nullable|image'
    ];

    /**
     * @param Request $request
     * @param $data
     * @return mixed
     */
    public function processImageUpload(Request $request, $data)
    {
        if ($request->exists('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
            $data['image'] = $coverPath;

            if (! app()->environment('testing')) {
                $this->resizeImage($coverPath);
            }
        }

        return $data;
    }

    /**
     * @param Book $book
     * @return array
     */
    public function createdResponseData(Book $book)
    {
        return $this->createdResponseDataBase($book, $this->showRouteName);
    }

    /**
     * @param Book $book
     * @return array
     */
    public function updatedResponseData(Book $book)
    {
        return $this->updatedResponseDataBase($book, $this->showRouteName);
    }

    /**
     * @param $path
     */
    private function resizeImage($path)
    {
        Image::make(storage_path('app/public/'.$path))->resize(256, 385)->save();
    }
}
