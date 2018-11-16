<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ApiAuthService;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new ApiAuthService();
        $this->middleware('auth:api')->only('logout');
    }

    /**
     * Авторизация пользователя для доступа к API.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        // Проверка правильности полученных данных
        if ($validator->fails()) {
            $responseData = $this->service->getFailedValidationResponseData($validator->errors());

            return response()->json($responseData, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $credentials = request(['email', 'password']);

        // Попытка авторизации с использованием данных из запроса
        if (! Auth::attempt($credentials)) {
            $responseData = $this->service->getUnauthorizedResponseData();

            return response()->json($responseData, Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = $request->user();

        // Проверка: пользователь - администратор
        if (! $user->admin) {
            $responseData = $this->service->getAccessDeniedResponseData();

            return response()->json($responseData, Response::HTTP_FORBIDDEN);
        }

        // Создание токена доступа
        $token = $this->service->createToken($user);

        $successResponseData = $this->service->getSuccessAuthResponseData($token);

        // Возвращение ответа с токеном
        return response()->json($successResponseData);
    }

    /**
     * Завершение сеанса авторизации пользователя.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        $successfullyLogoutResponseData = $this->service->getSuccessfullyLogoutResponseData();

        return response()->json($successfullyLogoutResponseData);
    }
}
