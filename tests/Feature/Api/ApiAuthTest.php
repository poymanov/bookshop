<?php

namespace Tests\Feature\Api;

use App\Services\ApiAuthService;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class ApiAuthTest extends ApiTestCase
{
    use RefreshDatabase;

    /**
     * Попытка авторизации без указания данных пользователя
     *
     * @test
     */
   public function login_validation_failed()
   {
       $response = $this->json('post', route('api.auth.login'));
       $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

       $response->assertExactJson([
           'data' => [
               'message' => ApiAuthService::RESPONSE_DATA['VALIDATION_FAILED']['MESSAGE'],
               'errors' => [
                   'email' => ['The email field is required.'],
                   'password' => ['The password field is required.'],
               ],
           ]
       ]);
   }

    /**
     * Попытка авторизации данными пользователя, которого нет в базе
     *
     * @test
     */
    public function login_unknown_user()
    {
        $authData = ['email' => 'test@test.ru', 'password' => '123qwe'];

        $response = $this->json('post', route('api.auth.login'), $authData);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response->assertExactJson([
            'data' => [
                'message' => ApiAuthService::RESPONSE_DATA['UNAUTHORIZED']['MESSAGE'],
                'errors' => ApiAuthService::RESPONSE_DATA['UNAUTHORIZED']['ERRORS'],
            ]
        ]);
    }

    /**
     * Попытка авторизации обычным пользователем (без прав администратора)
     *
     * @test
     */
    public function login_as_user()
    {
        $user = create(User::class);
        $authData = ['email' => $user->email, 'password' => 'secret'];

        $response = $this->json('post', route('api.auth.login'), $authData);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response->assertExactJson([
            'data' => [
                'message' => ApiAuthService::RESPONSE_DATA['ACCESS_DENIED']['MESSAGE'],
                'errors' => ApiAuthService::RESPONSE_DATA['ACCESS_DENIED']['ERRORS'],
            ]
        ]);
    }

    /**
     * Успешная авторизация пользователя с правами администратора
     *
     * @test
     */
    public function login_as_admin()
    {
        $this->artisan('passport:install');

        $user = $this->createAdmin();
        $authData = ['email' => $user->email, 'password' => 'secret'];

        $response = $this->json('post', route('api.auth.login'), $authData);
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'data' => [
                'access_token', 'token_type', 'expires_at',
            ]
        ]);
    }

    /**
     * Попытка прекратить сеанс авторизации неавторизованным пользователем
     *
     * @test
     */
    public function logout_as_unauthorized_user()
    {
        $response = $this->json('get', route('api.auth.logout'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response->assertExactJson([
            'data' => [
                'message' => ApiAuthService::RESPONSE_DATA['UNAUTHORIZED_LOGOUT']['MESSAGE'],
                'errors' => ApiAuthService::RESPONSE_DATA['UNAUTHORIZED_LOGOUT']['ERRORS'],
            ]
        ]);
    }

    /**
     * Прекращение сеанса авторизованного пользователя
     *
     * @test
     */
    public function api_logout()
    {
        $this->authApi();

        $response = $this->json('get', route('api.auth.logout'));
        $response->assertStatus(Response::HTTP_OK);

        $response->assertExactJson([
            'data' => [
                'message' => ApiAuthService::RESPONSE_DATA['SUCCESSFULLY_LOGOUT']['MESSAGE'],
            ]
        ]);
    }
}
