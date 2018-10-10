<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function show_last_books_on_desc_order()
    {
        factory('App\Book', 20)->create();

        $response = $this->get('/');
        $response->assertSuccessful();

        $books = Book::getLast();
        $booksTitle = $books->pluck('title');

        $response->assertSeeInOrder($booksTitle->all());
    }
}
