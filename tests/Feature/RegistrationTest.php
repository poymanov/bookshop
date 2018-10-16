<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_unauthorised_user_can_register()
    {
        $this->get('register')->assertStatus(200);

        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@test.ru',
            'password' => '123qwe',
            'password_confirmation' => '123qwe'
        ])->assertRedirect('/');

        $this->assertAuthenticated();
    }
}