<?php

use App\Http\Controllers\Admin\ProjectActivityController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/project-activities', [ProjectActivityController::class, 'index'])
        ->middleware('web.permission:project_activities.view')
        ->name('project-activities.index');

    Route::get('/project-activities/create', [ProjectActivityController::class, 'create'])
        ->middleware('web.permission:project_activities.create')
        ->name('project-activities.create');

    Route::post('/project-activities', [ProjectActivityController::class, 'store'])
        ->middleware('web.permission:project_activities.create')
        ->name('project-activities.store');

    // Keep the literal /edit route BEFORE /{projectActivity} so it is not captured as an ID.
    Route::get('/project-activities/{projectActivity}/edit', [ProjectActivityController::class, 'edit'])
        ->middleware('web.permission:project_activities.update')
        ->name('project-activities.edit');

    Route::get('/project-activities/{projectActivity}', [ProjectActivityController::class, 'show'])
        ->middleware('web.permission:project_activities.view')
        ->name('project-activities.show');

    Route::put('/project-activities/{projectActivity}', [ProjectActivityController::class, 'update'])
        ->middleware('web.permission:project_activities.update')
        ->name('project-activities.update');

    Route::delete('/project-activities/{projectActivity}', [ProjectActivityController::class, 'destroy'])
        ->middleware('web.permission:project_activities.delete')
        ->name('project-activities.destroy');
});
