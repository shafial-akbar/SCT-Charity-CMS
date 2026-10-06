<?php

use App\Http\Controllers\Api\V1\ProgramController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {

    Route::get('/programs', [ProgramController::class, 'index'])
        ->name('api.v1.programs.index');

    Route::get('/programs/{slug}', [ProgramController::class, 'show'])
        ->name('api.v1.programs.show');
});