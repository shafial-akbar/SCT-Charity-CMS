<?php

use App\Http\Controllers\Api\V1\ProjectActivityController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    Route::get('/project-activities', [ProjectActivityController::class, 'index'])
        ->name('api.v1.project-activities.index');

    Route::get('/project-activities/project/{slug}', [ProjectActivityController::class, 'project'])
        ->name('api.v1.project-activities.project');

    Route::get('/project-activities/{id}', [ProjectActivityController::class, 'show'])
        ->name('api.v1.project-activities.show');
});
