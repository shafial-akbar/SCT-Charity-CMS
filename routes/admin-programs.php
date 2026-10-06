<?php

use App\Http\Controllers\Admin\ProgramController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/programs', [ProgramController::class, 'index'])
            ->middleware('web.permission:programs.view')
            ->name('programs.index');

        Route::get('/programs/create', [ProgramController::class, 'create'])
            ->middleware('web.permission:programs.create')
            ->name('programs.create');

        Route::post('/programs', [ProgramController::class, 'store'])
            ->middleware('web.permission:programs.create')
            ->name('programs.store');

        Route::get('/programs/{program}/edit', [ProgramController::class, 'edit'])
            ->middleware('web.permission:programs.update')
            ->name('programs.edit');

        Route::put('/programs/{program}', [ProgramController::class, 'update'])
            ->middleware('web.permission:programs.update')
            ->name('programs.update');

        Route::delete('/programs/{program}', [ProgramController::class, 'destroy'])
            ->middleware('web.permission:programs.delete')
            ->name('programs.destroy');
    });