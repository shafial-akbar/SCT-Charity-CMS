<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

        then: function () {

            // Main Admin routes
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));

            // Pages + Page Sections Admin CRUD routes
            Route::middleware('web')
                ->group(base_path('routes/admin-pages.php'));

            // Pages + Page Sections Public API routes
            Route::middleware('api')
                ->group(base_path('routes/api-pages.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'web.permission' => \App\Http\Middleware\CheckWebPermission::class,
        ]);

        $middleware->redirectGuestsTo(
            fn () => route('admin.login')
        );

        $middleware->redirectUsersTo(
            fn () => route('admin.dashboard')
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();