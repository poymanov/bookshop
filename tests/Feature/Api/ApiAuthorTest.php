<?php

namespace Tests\Feature\Api;

use App\Author;

use App\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;

class ApiAuthorTest extends ApiTestCase
{
    /**
     * @test
     */
    public function get_author()
    {
        $book = create(Author::class);

        $response = $this->json('get', route('api.authors.show', $book));
        $response->assertStatus(Response::HTTP_OK);

        $authorArray = $this->authorsToArray([$book]);

        $response->assertExactJson([
            'data' => $authorArray,
        ]);
    }

    /**
     * @test
     */
    public function get_not_existed_author()
    {
        $response = $this->json('get', route('api.authors.show', 999));
        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $response->assertExactJson([
            'data' => [
                'message' => 'Resource not found',
                'status_code' => Response::HTTP_NOT_FOUND
            ]
        ]);
    }

    /**
     * @test
     */
    public function get_authors_list()
    {
        $authors = create(Author::class, [],3);

        $authorsArray = $this->authorsToArray($authors);

        $response = $this->json('get', route('api.authors.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertExactJson([
            'data' => $authorsArray,
            'links' => [
                'first' => route('api.authors.index').'?page=1',
                'last' => route('api.authors.index').'?page=1',
                'prev' => null,
                'next' => null,
            ],
            'meta' => [
                'current_page' => 1,
                'from' => 1,
                'last_page' => 1,
                'path' => route('api.authors.index'),
                'per_page' => 10,
                'to' => 3,
                'total' => 3

            ]
        ]);
    }

    /**
     * @test
     */
    public function get_authors_list_with_more_one_page()
    {
        create(Author::class, [],20);

        $response = $this->json('get', route('api.authors.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(['links' => [
            'first' => route('api.authors.index').'?page=1',
            'last' => route('api.authors.index').'?page=2',
            'next' => route('api.authors.index').'?page=2',
            'prev' => null,
        ]]);
    }

    /**
     * @test
     */
    public function create_author_validation_failed()
    {
        $response = $this->json('post', route('api.authors.store'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertExactJson([
            'data' => [
                'message' => 'Validation failed',
                'errors' => [
                    'name' => ['The name field is required.'],
                    'description' => ['The description field is required.'],
                ],
            ]
        ]);
    }

    /**
     * @test
     */
    public function create_author_success()
    {
        $author = make(Author::class);

        $response = $this->json('post', route('api.authors.store'), $author->toArray());
        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('authors', [
            'name' => $author->name,
            'description' => $author->description,
        ]);

        $book = Author::first();

        $response->assertExactJson([
            'data' => [
                'message' => 'Successfully created',
                'url' => route('api.authors.show', $book)
            ]
        ]);
    }

    /**
     * @test
     */
    public function update_author_validation_failed()
    {
        $author = create(Author::class);

        $response = $this->json('patch', route('api.authors.update', $author), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertExactJson([
            'data' => [
                'message' => 'Validation failed',
                'errors' => [
                    'name' => ['The name field is required.'],
                    'description' => ['The description field is required.'],
                ],
            ]
        ]);
    }

    /**
     * @test
     */
    public function update_author_success()
    {
        $author = create(Author::class);
        $newName = 'test';

        $updateData = $author->toArray();
        $updateData['name'] = $newName;

        $response = $this->json('patch', route('api.authors.update', $author), $updateData);
        $response->assertStatus(Response::HTTP_OK);

        $response->assertExactJson([
            'data' => [
                'message' => 'Successfully updated',
                'url' => route('api.authors.show', $author)
            ]
        ]);

        $this->assertEquals($newName, $author->fresh()->name);
    }

    /**
     * @test
     */
    public function delete_book()
    {
        $author = create(Author::class);

        $response = $this->json('delete', route('api.authors.destroy', $author));

        $this->assertDatabaseMissing('authors', [
            'id' => $author->id,
        ]);

        $response->assertExactJson([
            'data' => [
                'message' => 'Successfully deleted',
            ]
        ]);
    }

    /**
     * @test
     */
    public function books_list_by_author()
    {
        $author = create(Author::class);
        $books = create(Book::class, ['author_id' => $author->id], 10);

        $booksArray = $this->booksToArray($books);
        $response = $this->json('get', route('api.authors.books', $author));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertExactJson([
            'data' => $booksArray,
            'links' => [
                'first' => route('api.authors.books', $author).'?page=1',
                'last' => route('api.authors.books', $author).'?page=1',
                'prev' => null,
                'next' => null,
            ],
            'meta' => [
                'current_page' => 1,
                'from' => 1,
                'last_page' => 1,
                'path' => route('api.authors.books', $author),
                'per_page' => 10,
                'to' => 10,
                'total' => 10,

            ]
        ]);

    }
}
