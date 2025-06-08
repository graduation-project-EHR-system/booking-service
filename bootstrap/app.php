<?php

use App\Http\Middleware\EnforceJsonResponseForApiRequests;
use App\Providers\RepositoryServiceProvider;

use App\Util\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        then: function () {
            Route::prefix('api/v1')
                ->group(base_path('routes/v1/api.php'));
        },
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(EnforceJsonResponseForApiRequests::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $e) {
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                return ApiResponse::send(
                    code: Response::HTTP_NOT_FOUND,
                    message: 'Model not found.'
                );
            }
        });
    })
    ->withProviders([
        RepositoryServiceProvider::class,
    ])
    ->create();
