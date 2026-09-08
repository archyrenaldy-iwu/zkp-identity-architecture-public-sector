<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            // \Illuminate\Http\Middleware\TrustHosts::class,
            // \Illuminate\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\XSS::class,
        ]);

        $middleware->group('web', [
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            App\Http\Middleware\LogMiddleware::class,
            Illuminate\Cookie\Middleware\EncryptCookies::class,
        ]);

        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            App\Http\Middleware\LogMiddleware::class,
        ]);

        $middleware->alias([
            'permission' => App\Http\Middleware\EnsureUserHasPermission::class,
            'custom.permission' => \App\Http\Middleware\CheckSpecificPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (HttpException $e) {
            if ($e->getStatusCode() === 401) {
                return responseJson(
                    [
                        'message' => 'Unauthorized',
                        'http_code' => 401,
                        'success' => false,
                    ]
                );
            }
            if ($e->getStatusCode() === 404) {
                return responseJson(
                    [
                        'message' => 'Not Found',
                        'http_code' => 404,
                        'success' => false,
                    ]
                );
            }
        });

        $exceptions->render(function (ModelNotFoundException $e) {
            return responseJson(
                [
                    'message' => 'Not Found',
                    'http_code' => 404,
                    'success' => false,
                ]
            );
        });

    })->create();
