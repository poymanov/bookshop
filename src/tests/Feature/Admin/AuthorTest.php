<?php

namespace Tests\Feature\Admin;

use App\Author;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
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
    public function index_page_have_authors()
    {
        $indexUrl = route('admin.authors.index');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $authors = create('App\Author', [] ,5);

        $response = $this->get($indexUrl);
        $response->assertSee('Authors');

        $authorsNames = $authors->pluck('name');

        $response->assertSeeInOrder($authorsNames->all());
    }

    /**
     * @test
     */
    public function view_page()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $author = create('App\Author');
        $books = factory('App\Book', 3)->create(['author_id' => $author->id]);
        $viewUrl = route('admin.authors.show', $author);

        $response = $this->get($viewUrl);
        $response->assertSuccessful();

        $response->assertSee($author->title);
        $response->assertSee($author->description);

        $booksTitle = $books->pluck('title');
        $response->assertSeeInOrder($booksTitle->all());
    }

    /**
     * @test
     */
    public function dont_see_table_for_author_without_books()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $author = create('App\Author');

        $viewUrl = route('admin.authors.show', $author);
        $response = $this->get($viewUrl);

        $response->assertDontSee('Title');
        $response->assertDontSee('Year');
        $response->assertDontSee('ISBN');
        $response->assertDontSee('Pages');
        $response->assertDontSee('Price');
    }

    /**
     * @test
     */
    public function create_page()
    {
        $createUrl = route('admin.authors.create');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $response = $this->get($createUrl);
        $response->assertSuccessful();

        $response->assertSee('New author');
        $response->assertSee('Name');
        $response->assertSee('Description');
        $response->assertSee('Create');
    }

    /**
     * @test
     */
    public function create_validation_failed()
    {
        $storeUrl = route('admin.authors.store');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $this->post($storeUrl)->assertSessionHasErrors(['name', 'description']);
    }

    /**
     * @test
     */
    public function create_successful()
    {
        $storeUrl = route('admin.authors.store');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $author = make('App\Author');
        $response = $this->post($storeUrl, $author->toArray());

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('authors', [
            'name' => $author->name, 'description' => $author->description
        ]);

        $redirectUrl = route('admin.authors.show', 1);
        $response->assertRedirect($redirectUrl);

    }

    /**
     * @test
     */
    public function edit_page()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $author = create('App\Author');

        $editUrl = route('admin.authors.edit', $author);

        $response = $this->get($editUrl);
        $response->assertSuccessful();

        $response->assertSee('Edit author');
        $response->assertSee($author->name);
        $response->assertSee($author->description);
        $response->assertSee('Update');
    }

    /**
     * @test
     */
    public function edit_validation_failed()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $author = create('App\Author');

        $updateUrl = route('admin.authors.update', $author);

        $this->patch($updateUrl, [])->assertSessionHasErrors(['name', 'description']);
    }

    /**
     * @test
     */
    public function edit_validation_successful()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $author = create('App\Author');

        $updateUrl = route('admin.authors.update', $author);

        $newAuthorData = make('App\Author');

        $response = $this->patch($updateUrl, $newAuthorData->toArray());

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('authors', [
            'name' => $newAuthorData->name, 'description' => $newAuthorData->description
        ]);

        $redirectUrl = route('admin.authors.show', $author);
        $response->assertRedirect($redirectUrl);
    }

    /**
     * @test
     */
    public function delete_successful()
    {
        $admin = $this->createAdmin();
        $this->signIn($admin);

        $author = create('App\Author');
        $books = factory('App\Book', 3)->create(['author_id' => $author->id]);

        $destroyUrl = route('admin.authors.destroy', $author);

        $response = $this->delete($destroyUrl);

        $this->assertDatabaseMissing('authors', [
            'name' => $author->name, 'description' => $author->description
        ]);

        $redirectUrl = route('admin.authors.index');
        $response->assertRedirect($redirectUrl);

        foreach ($books as $book) {
            $this->assertDatabaseMissing('books', [
                'id' => $book->id
            ]);
        }
    }

    private function createAdmin()
    {
        return factory('App\User')->state('admin')->create();
    }

    private function getUserRestrictedRoutes()
    {
        $author = create('App\Author');

        $routes = [
            [
                'path' => route('admin.authors.index')
            ],
            [
                'path' => route('admin.authors.show', $author)
            ],
            [
                'path' => route('admin.authors.create')
            ],
            [
                'method' => 'post',
                'path' => route('admin.authors.store')
            ],
            [
                'path' => route('admin.authors.edit', $author)
            ],
            [
                'method' => 'patch',
                'path' => route('admin.authors.update', $author)
            ],
            [
                'method' => 'delete',
                'path' => route('admin.authors.destroy', $author)
            ],
        ];

        return $routes;
    }
}
