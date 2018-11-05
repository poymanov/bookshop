<?php

namespace App\Services;

use Image;
use App\Book;
use Validator;
use Illuminate\Http\Request;

class BooksService
{
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
     * @param $errors
     * @return array
     */
    private function getFailedValidationData($message, $errors)
    {
        $data = $this->createJsonResponseData($message);
        $data['data']['errors'] = $errors;

        return $data;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validateJsonRequest(Request $request)
    {
        $validator = Validator::make($request->all(), self::VALIDATION_RULES);

        if ($validator->fails()) {
            $message = 'Validation failed';
            $errorData = $this->getFailedValidationData($message, $validator->errors());

            return [false, $errorData];
        }

        return [true, $validator->getData()];
    }

    /**
     * @param Book $book
     * @return array
     */
    public function createdResponseData(Book $book)
    {
        $message = 'Successfully created';

        $data = $this->createJsonResponseData($message);
        $data['data']['url'] = route('api.books.show', $book);

        return $data;
    }

    /**
     * @param Book $book
     * @return array
     */
    public function updatedResponseData(Book $book)
    {
        $message = 'Successfully updated';

        $data = $this->createJsonResponseData($message);
        $data['data']['url'] = route('api.books.show', $book);

        return $data;
    }

    /**
     * @param Book $book
     * @return array
     */
    public function deletedResponseData(Book $book)
    {
        $message = 'Successfully deleted';

        return $this->createJsonResponseData($message);
    }

    /**
     * @param $message
     * @return array
     */
    private function createJsonResponseData($message)
    {
        return [
            'data' => [
                'message' => $message,
            ]
        ];
    }

    /**
     * @param $path
     */
    private function resizeImage($path)
    {
        Image::make(storage_path('app/public/'.$path))->resize(256, 385)->save();
    }
}
