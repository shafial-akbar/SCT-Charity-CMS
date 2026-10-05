<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin Guest Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'create'])
            ->name('admin.login');

        Route::post('/login', [AdminLoginController::class, 'store'])
            ->middleware('throttle:login')
            ->name('admin.login.store');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Authenticated Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {

        Route::post('/logout', [AdminLoginController::class, 'destroy'])
            ->name('admin.logout');

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('/', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        Route::middleware('web.permission:users.view')->group(function () {
            Route::get('/users', [UserController::class, 'index'])
                ->name('admin.users.index');
        });

        Route::middleware('web.permission:users.create')->group(function () {
            Route::get('/users/create', [UserController::class, 'create'])
                ->name('admin.users.create');

            Route::post('/users', [UserController::class, 'store'])
                ->name('admin.users.store');
        });

        Route::middleware('web.permission:users.update')->group(function () {
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])
                ->name('admin.users.edit');

            Route::put('/users/{user}', [UserController::class, 'update'])
                ->name('admin.users.update');
        });

        Route::middleware('web.permission:users.delete')->group(function () {
            Route::delete('/users/{user}', [UserController::class, 'destroy'])
                ->name('admin.users.destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */
        Route::middleware('web.permission:roles.view')->group(function () {
            Route::get('/roles', [RoleController::class, 'index'])
                ->name('admin.roles.index');
        });

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */
        Route::middleware('web.permission:permissions.view')->group(function () {
            Route::get('/permissions', [PermissionController::class, 'index'])
                ->name('admin.permissions.index');
        });
    });
});