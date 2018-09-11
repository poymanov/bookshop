<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function author_have_got_books()
    {
        $author = factory('App\Author')->create();
        $books = factory('App\Book', 3)->create(['author_id' => $author->id]);

        $this->assertCount(3, $author->books);
    }
}
