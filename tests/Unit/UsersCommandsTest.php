<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersCommandsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function successful_create_admin()
    {
        $name = 'admin';
        $email = 'admin@admin.ru';
        $password = '123qwe';

        $this->artisan('users:create-admin')
            ->expectsQuestion('Name', $name)
            ->expectsQuestion('Email', $email)
            ->expectsQuestion('Password', $password)
            ->expectsQuestion('Repeat password', $password)
            ->expectsOutput('Admin user was successful created')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', ['name' => $name, 'email' => $email, 'admin' => true]);
    }

    /**
     * @test
     */
    public function create_admin_with_wrong_repeat_password()
    {
        $name = 'admin';
        $email = 'admin@admin.ru';

        $this->artisan('users:create-admin')
            ->expectsQuestion('Name', $name)
            ->expectsQuestion('Email', $email)
            ->expectsQuestion('Password', '123qwe')
            ->expectsQuestion('Repeat password', 'qwe123')
            ->expectsOutput('Entered passwords not equal')
            ->assertExitCode(1);

        $this->assertDatabaseMissing('users', ['name' => $name, 'email' => $email, 'admin' => true]);
    }

    /**
     * @test
     */
    public function create_admin_with_existed_data()
    {
        $user = factory('App\User')->state('admin')->create(['name' => 'admin', 'email' => 'admin@admin.ru']);

        $this->artisan('users:create-admin')
            ->expectsQuestion('Name', $user->name)
            ->expectsQuestion('Email', $user->email)
            ->expectsQuestion('Password', '123qwe')
            ->expectsQuestion('Repeat password', '123qwe')
            ->assertExitCode(1);
    }
}
