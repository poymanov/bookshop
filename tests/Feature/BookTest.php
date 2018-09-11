<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function unknown_book_page()
    {
        $response = $this->get('/books/9999');
        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function particular_book_page()
    {
        $book = factory('App\Book')->create(['price' => 9999]);

        $response = $this->get('/books/' . $book->id);

        $response->assertSuccessful();

        $response->assertSee($book->title);
        $response->assertSee($book->description);
        $response->assertSee($book->author);
        $response->assertSee($book->isbn);
        $response->assertSee($book->year);
        $response->assertSee($book->pages_count);
        $response->assertSee($book->price);
    }
}
