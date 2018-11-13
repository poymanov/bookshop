<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTestCase extends TestCase
{
    use RefreshDatabase;

    /**
     * @param $authors
     * @return array|mixed
     */
    protected function authorsToArray($authors)
    {
        $authorsArray = [];

        foreach ($authors as $author) {
            $authorsArray[] = [
                'id' => $author->id,
                'name' => $author->name,
                'description' => $author->description,
            ];
        }

        return count($authorsArray) == 1 ? $authorsArray[0] : $authorsArray;
    }

    /**
     * @param $books
     * @return array|mixed
     */
    protected function booksToArray($books)
    {
        $booksArray = [];

        foreach ($books as $book) {
            $authorData = $this->authorsToArray([$book->author]);

            $booksArray[] = [
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'isbn' => $book->isbn,
                'year' => $book->year,
                'pages_count' => $book->pages_count,
                'price' => $book->price,
                'image' => $book->image,
                'author' => $authorData,
            ];
        }

        return count($booksArray) == 1 ? $booksArray[0] : $booksArray;
    }
}
