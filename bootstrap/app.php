<?php

use App\Helpers\ResponseHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('api/v1')->middleware('api')->group(base_path('routes/api/v1.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                if ($e instanceof ValidationException) {
                    // Send default response
                } else if ($e instanceof UnauthorizedException || $e instanceof AuthenticationException) {
                    return ResponseHelper::unauthorized($e->getMessage());
                } else if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                    return ResponseHelper::notFound(__('messages.resource_not_found'));
                } else {
                    return ResponseHelper::exceptionError($e);
                }
            }
        });
    })->create();
