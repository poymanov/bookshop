<?php

namespace Tests\Unit;

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
}
