<?php

use App\Http\Middleware\AdminRoles;
use App\Http\Middleware\TokenIsValid;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        using: function () {
            Route::prefix('api/mobile')
                ->name('mobile.')
                ->group(base_path('routes/mobile.php'));

            Route::prefix('api/common')
                ->name('common.')
                ->group(base_path('routes/common.php'));

            Route::prefix('api/backoffice')
                ->name('backoffice.')
                ->group(base_path('routes/backoffice.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);
        $middleware->alias([
            'roles' => AdminRoles::class,
            'token-valid' => TokenIsValid::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
