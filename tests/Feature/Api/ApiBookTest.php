<?php

namespace Tests\Feature\Api;

use App\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;

class ApiBookTest extends ApiTestCase
{
    /**
     * @test
     */
    public function get_book()
    {
        $book = create(Book::class);

        $response = $this->json('get', route('api.books.show', $book));
        $response->assertStatus(Response::HTTP_OK);

        $bookArray = $this->booksToArray([$book]);

        $response->assertExactJson([
            'data' => $bookArray
        ]);
    }

    /**
     * @test
     */
    public function get_not_existed_book()
    {
        $response = $this->json('get', route('api.books.show', 999));
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
    public function get_books_list()
    {
        $books = create(Book::class, [],3);

        $booksArray = $this->booksToArray($books);

        $response = $this->json('get', route('api.books.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertExactJson([
            'data' => $booksArray,
            'links' => [
                'first' => route('api.books.index').'?page=1',
                'last' => route('api.books.index').'?page=1',
                'prev' => null,
                'next' => null,
            ],
            'meta' => [
                'current_page' => 1,
                'from' => 1,
                'last_page' => 1,
                'path' => route('api.books.index'),
                'per_page' => 10,
                'to' => 3,
                'total' => 3

            ]
        ]);
    }

    /**
     * @test
     */
    public function get_books_list_with_more_one_page()
    {
        create(Book::class, [],20);

        $response = $this->json('get', route('api.books.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(['links' => [
            'first' => route('api.books.index').'?page=1',
            'last' => route('api.books.index').'?page=2',
            'next' => route('api.books.index').'?page=2',
            'prev' => null,
        ]]);
    }

    /**
     * @test
     */
    public function create_book_validation_failed()
    {
        $response = $this->json('post', route('api.books.store'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertExactJson([
            'data' => [
                'message' => 'Validation failed',
                'errors' => [
                    'title' => ['The title field is required.'],
                    'description' => ['The description field is required.'],
                    'author_id' => ['The author id field is required.'],
                    'isbn' => ['The isbn field is required.'],
                    'year' => ['The year field is required.'],
                    'pages_count' => ['The pages count field is required.'],
                    'price' => ['The price field is required.'],
                ],
            ]
        ]);
    }

    /**
     * @test
     */
    public function create_book_success()
    {
        $book = make(Book::class);

        $response = $this->json('post', route('api.books.store'), $book->toArray());
        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('books', [
            'title' => $book->title,
            'description' => $book->description,
            'author_id' => $book->author_id,
            'isbn' => $book->isbn,
            'year' => $book->year,
            'pages_count' => $book->pages_count,
            'price' => $book->price,
        ]);

        $book = Book::first();

        $response->assertExactJson([
            'data' => [
                'message' => 'Successfully created',
                'url' => route('api.books.show', $book)
            ]
        ]);
    }

    /**
     * @test
     */
    public function create_book_success_with_image()
    {
        Storage::fake('public');

        $book = make(Book::class);

        $file = UploadedFile::fake()->image('book.jpg');

        $response = $this->json('post', route('api.books.store'), array_merge($book->toArray(), ['cover' => $file]));
        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('books', [
            'image' => 'covers/' . $file->hashName(),
        ]);

        Storage::disk('public')->assertExists('covers/' . $file->hashName());
    }

    /**
     * @test
     */
    public function update_book_validation_failed()
    {
        $book = create(Book::class);

        $response = $this->json('patch', route('api.books.update', $book), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertExactJson([
            'data' => [
                'message' => 'Validation failed',
                'errors' => [
                    'title' => ['The title field is required.'],
                    'description' => ['The description field is required.'],
                    'author_id' => ['The author id field is required.'],
                    'isbn' => ['The isbn field is required.'],
                    'year' => ['The year field is required.'],
                    'pages_count' => ['The pages count field is required.'],
                    'price' => ['The price field is required.'],
                ],
            ]
        ]);
    }

    /**
     * @test
     */
    public function update_book_success()
    {
        $book = create(Book::class);
        $newPrice = 999;

        $updateData = $book->toArray();
        $updateData['price'] = $newPrice;

        $response = $this->json('patch', route('api.books.update', $book), $updateData);
        $response->assertStatus(Response::HTTP_OK);

        $response->assertExactJson([
            'data' => [
                'message' => 'Successfully updated',
                'url' => route('api.books.show', $book)
            ]
        ]);

        $this->assertEquals($newPrice, $book->fresh()->price);
    }

    /**
     * @test
     */
    public function update_book_success_with_image()
    {
        Storage::fake('public');

        $book = create(Book::class);

        $file = UploadedFile::fake()->image('book.jpg');

        $response = $this->json('patch', route('api.books.update', $book), array_merge($book->toArray(), ['cover' => $file]));
        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('books', [
            'image' => 'covers/' . $file->hashName(),
        ]);

        Storage::disk('public')->assertExists('covers/' . $file->hashName());
    }

    /**
     * @test
     */
    public function delete_book()
    {
        $book = create(Book::class);

        $response = $this->json('delete', route('api.books.destroy', $book));

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);

        $response->assertExactJson([
            'data' => [
                'message' => 'Successfully deleted',
            ]
        ]);
    }
}
