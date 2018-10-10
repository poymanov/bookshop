<?php

namespace Tests\Unit;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function book_have_got_default_image()
    {
        $customImagePath = 'test.jpg';

        $book = factory('App\Book')->create(['image' => $customImagePath]);

        $this->assertEquals($book->image, $customImagePath);

        $book = factory('App\Book')->create();

        $this->assertEquals($book->image, $book::DEFAULT_IMAGE_URL);
    }

    /**
     * @test
     */
    public function book_have_got_author()
    {
        $author = factory('App\Author')->create();
        $book = factory('App\Book')->create(['author_id' => $author->id]);

        $this->assertEquals($book->author->id, $author->id);
    }
}
