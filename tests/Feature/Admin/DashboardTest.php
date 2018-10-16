<?php

namespace Tests\Feature\Admin;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function users_have_not_access_to_dashboard()
    {
        $dashboardUrl = route('admin.index');

        $response = $this->get($dashboardUrl);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $this->signIn();
        $response = $this->get($dashboardUrl);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        auth()->logout();
    }

    /**
     * @test
     */
    public function dashboard_have_authors()
    {
        $dashboardUrl = route('admin.index');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $authors = create('App\Author', [] ,7);

        $response = $this->get($dashboardUrl);
        $response->assertSee('Last authors');

        $authorsNames = $authors->pluck('name');

        $response->assertSeeInOrder($authorsNames->all());
    }

    /**
     * @test
     */
    public function dashboard_have_books()
    {
        $dashboardUrl = route('admin.index');

        $admin = $this->createAdmin();
        $this->signIn($admin);

        $books = create('App\Book', [] ,7);

        $response = $this->get($dashboardUrl);
        $response->assertSee('Last books');

        $booksNames = $books->pluck('name');

        $response->assertSeeInOrder($booksNames->all());
    }
}
