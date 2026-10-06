<?php

use App\Http\Controllers\Api\V1\PeopleController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    Route::get('/people', [PeopleController::class, 'index'])
        ->name('api.v1.people.index');

    Route::get('/people/{id}', [PeopleController::class, 'show'])
        ->name('api.v1.people.show');
});
