<?php

namespace Tests\Feature\Admin;

use App\Book;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function users_have_not_access_to_pages()
    {
        $restrictedRoutes = $this->getUserRestrictedRoutes();

        foreach ($restrictedRoutes as $route) {
            if (isset($route['method'])) {
                $method = $route['method'];
            } else {
                $method = 'get';
            }


            $response = $this->$method($route['path']);
            $response->assertStatus(Response::HTTP_FORBIDDEN);

            $this->signIn();
            $response = $this->$method($route['path']);
            $response->assertStatus(Response::HTTP_FORBIDDEN);

            auth()->logout();
        }
    }

    /**
     * @test
     */
    public function index_page_have_books()
    {
        $indexUrl = route('admin.books.index');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $books = create('App\Book', [] ,5);

        $response = $this->get($indexUrl);
        $response->assertSee('Books');

        $booksNames = $books->pluck('title');

        $response->assertSeeInOrder($booksNames->all());
    }

    /**
     * @test
     */
    public function view_page()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $author = create('App\Author');
        $book = create('App\Book', ['author_id' => $author->id]);

        $viewUrl = route('admin.books.show', $book);

        $response = $this->get($viewUrl);
        $response->assertSuccessful();

        $response->assertSee($author->name);
        $response->assertSee($book->title);
        $response->assertSee($book->description);
        $response->assertSee($book->year);
        $response->assertSee($book->isbn);
        $response->assertSee($book->pages_count);
        $response->assertSee($book->price);
    }

    /**
     * @test
     */
    public function create_page()
    {
        $createUrl = route('admin.books.create');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $response = $this->get($createUrl);
        $response->assertSuccessful();

        $response->assertSee('New book');
        $response->assertSee('Title');
        $response->assertSee('Description');
        $response->assertSee('Year');
        $response->assertSee('ISBN');
        $response->assertSee('Pages');
        $response->assertSee('Price');
        $response->assertSee('Create');
    }

    /**
     * @test
     */
    public function create_validation_failed()
    {
        $storeUrl = route('admin.books.store');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $this->post($storeUrl)->assertSessionHasErrors([
            'title', 'description', 'author_id', 'isbn', 'year', 'pages_count', 'price'
        ]);
    }

    /**
     * @test
     */
    public function create_validation_failed_with_wrong_author()
    {
        $storeUrl = route('admin.books.store');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $book = make('App\Book');
        $book->author_id = 999;

        $this->post($storeUrl, $book->toArray())->assertSessionHasErrors(['author_id']);
    }

    /**
     * @test
     */
    public function create_successful()
    {
        $storeUrl = route('admin.books.store');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $book = make('App\Book');
        $response = $this->post($storeUrl, $book->toArray());

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('books', [
            'title' => $book->title, 'description' => $book->description,
            'author_id' => $book->author_id, 'isbn' => $book->isbn,
            'year' => $book->year, 'pages_count' => $book->pages_count,
        ]);

        $redirectUrl = route('admin.books.show', 1);
        $response->assertRedirect($redirectUrl);
    }

    /**
     * @test
     */
    public function create_successful_with_image()
    {
        Storage::fake('public');

        $storeUrl = route('admin.books.store');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $file = UploadedFile::fake()->image('book.jpg');

        $book = make('App\Book');

        $response = $this->post($storeUrl, array_merge($book->toArray(), ['cover' => $file]));

        $response->assertSessionHasNoErrors();

        $book = Book::first();

        $this->assertEquals($book->image, asset('storage/covers/' . $file->hashName()));

        Storage::disk('public')->assertExists('covers/' . $file->hashName());

    }

    /**
     * @test
     */
    public function edit_page()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $book = create('App\Book');

        $editUrl = route('admin.books.edit', $book);

        $response = $this->get($editUrl);
        $response->assertSuccessful();

        $response->assertSee('Edit book');
        $response->assertSee('New book');
        $response->assertSee('Title');
        $response->assertSee('Description');
        $response->assertSee('Year');
        $response->assertSee('ISBN');
        $response->assertSee('Pages');
        $response->assertSee('Price');
        $response->assertSee('Update');
    }

    /**
     * @test
     */
    public function edit_validation_failed()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $book = create('App\Book');

        $updateUrl = route('admin.books.update', $book);

        $this->patch($updateUrl, [])->assertSessionHasErrors([
            'title', 'description', 'author_id', 'isbn', 'year', 'pages_count', 'price'
        ]);
    }

    /**
     * @test
     */
    public function update_validation_failed_with_wrong_author()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $book = create('App\Book');
        $book->author_id = 999;

        $updateUrl = route('admin.books.update', $book);

        $this->patch($updateUrl, $book->toArray())->assertSessionHasErrors(['author_id']);
    }

    /**
     * @test
     */
    public function edit_validation_successful()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $book = create('App\Book');

        $updateUrl = route('admin.books.update', $book);

        $newBookData = make('App\Book');

        $response = $this->patch($updateUrl, $newBookData->toArray());

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('books', [
            'title' => $newBookData->title, 'description' => $newBookData->description,
            'author_id' => $newBookData->author_id, 'isbn' => $newBookData->isbn,
            'year' => $newBookData->year, 'pages_count' => $newBookData->pages_count,
        ]);

        $redirectUrl = route('admin.books.show', $book);
        $response->assertRedirect($redirectUrl);
    }

    /**
     * @test
     */
    public function edit_validation_successful_with_image()
    {
        Storage::fake('public');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $book = create('App\Book');

        $updateUrl = route('admin.books.update', $book);

        $newBookData = make('App\Book');

        $file = UploadedFile::fake()->image('book.jpg');

        $response = $this->patch($updateUrl, array_merge($newBookData->toArray(), ['cover' => $file]));

        $response->assertSessionHasNoErrors();

        $this->assertEquals($book->fresh()->image, asset('storage/covers/' . $file->hashName()));

        Storage::disk('public')->assertExists('covers/' . $file->hashName());
    }

    /** @test */
    public function create_book_with_valid_image()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $storeUrl = route('admin.books.store');

        $response = $this->post($storeUrl, ['cover' => 'not-an-image']);

        $response->assertSessionHasErrors('cover');
    }

    /** @test */
    public function update_book_with_valid_image()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $book = create('App\Book');

        $updateUrl = route('admin.books.update', $book);

        $response = $this->patch($updateUrl, ['cover' => 'not-an-image']);

        $response->assertSessionHasErrors('cover');
    }

    /**
     * @test
     */
    public function delete_successful()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $book = create('App\Book');

        $destroyUrl = route('admin.books.destroy', $book);

        $response = $this->delete($destroyUrl);

        $this->assertDatabaseMissing('books', [
            'title' => $book->title, 'description' => $book->description,
            'author_id' => $book->author_id, 'isbn' => $book->isbn,
            'year' => $book->year, 'pages_count' => $book->pages_count,
        ]);

        $redirectUrl = route('admin.books.index');
        $response->assertRedirect($redirectUrl);
    }

    private function getUserRestrictedRoutes()
    {
        $book = create('App\Book');

        $routes = [
            [
                'path' => route('admin.books.index')
            ],
            [
                'path' => route('admin.books.show', $book)
            ],
            [
                'path' => route('admin.books.create')
            ],
            [
                'method' => 'post',
                'path' => route('admin.books.store')
            ],
            [
                'path' => route('admin.books.edit', $book)
            ],
            [
                'method' => 'patch',
                'path' => route('admin.books.update', $book)
            ],
            [
                'method' => 'delete',
                'path' => route('admin.books.destroy', $book)
            ],
        ];

        return $routes;
    }
}
