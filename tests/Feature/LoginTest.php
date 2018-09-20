<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_unauthorised_user_can_login()
    {
        $userPassword = '123qwe';

        $user = factory('App\User')->create(['password' => Hash::make($userPassword)]);

        $this->get('/login')->assertStatus(200);

        $this->post('/login', [
            'email' => $user->email,
            'password' => $userPassword
        ])->assertRedirect('home');

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function an_authorised_user_can_not_visit_login_page()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $this->get('login')->assertRedirect('/home');
    }
}