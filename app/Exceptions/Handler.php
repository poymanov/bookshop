<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use App\Services\ApiAuthService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->expectsJson() && $exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'data' => [
                    'message' => 'Resource not found',
                    'status_code' => Response::HTTP_NOT_FOUND
                ]
            ], Response::HTTP_NOT_FOUND);
        } elseif ($request->url() == route('api.auth.logout') && $exception instanceof \Illuminate\Auth\AuthenticationException) {
            $apiAuthService = new ApiAuthService();
            $unauthorizedResponseData = $apiAuthService->getUnauthorizedLogoutReponseData();

            return response()->json($unauthorizedResponseData, Response::HTTP_UNAUTHORIZED);
        }

        return parent::render($request, $exception);
    }
}
