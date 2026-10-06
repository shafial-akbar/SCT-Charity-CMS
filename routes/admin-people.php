<?php

use App\Http\Controllers\Admin\PeopleController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/people', [PeopleController::class, 'index'])
            ->middleware('web.permission:people.view')
            ->name('people.index');

        Route::get('/people/create', [PeopleController::class, 'create'])
            ->middleware('web.permission:people.create')
            ->name('people.create');

        Route::post('/people', [PeopleController::class, 'store'])
            ->middleware('web.permission:people.create')
            ->name('people.store');

        Route::get('/people/{person}', [PeopleController::class, 'show'])
            ->middleware('web.permission:people.view')
            ->name('people.show');

        Route::get('/people/{person}/edit', [PeopleController::class, 'edit'])
            ->middleware('web.permission:people.update')
            ->name('people.edit');

        Route::put('/people/{person}', [PeopleController::class, 'update'])
            ->middleware('web.permission:people.update')
            ->name('people.update');

        Route::delete('/people/{person}', [PeopleController::class, 'destroy'])
            ->middleware('web.permission:people.delete')
            ->name('people.destroy');
    });
