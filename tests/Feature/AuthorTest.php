<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function authors_index()
    {
       $authors = factory('App\Author', 5)->create();
       $response = $this->get('/authors');
       $response->assertSuccessful();

       $authorsNames = $authors->pluck('name');

       $response->assertSeeInOrder($authorsNames->all());
    }

    /**
     * @test
     */
    public function author_view()
    {
        $author = factory('App\Author')->create();

        $books = factory('App\Book', 3)->create(['author_id' => $author->id]);

        $response = $this->get('/authors/' . $author->id);
        $response->assertSuccessful();

        $response->assertSee($author->name);
        $response->assertSee($author->description);

        $booksTitle = $books->pluck('title');

        $response->assertSeeInOrder($booksTitle->all());

    }
}
