<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectActivityResource;
use App\Models\ProjectActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectActivityController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max($request->integer('per_page', 24), 1), 50);

        $activities = ProjectActivity::query()
            ->with('project')
            ->whereHas('project', fn ($q) => $q->where('status', 'active'))
            ->when($request->filled('project'), function ($q) use ($request) {
                $project = $request->string('project')->toString();

                $q->whereHas('project', function ($q) use ($project) {
                    $q->where('slug_en', $project)
                        ->orWhere('slug_bn', $project)
                        ->orWhere('id', $project);
                });
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->orderBy('activity_date')
            ->orderBy('sort_order')
            ->latest('created_at')
            ->paginate($perPage);

        return ProjectActivityResource::collection($activities);
    }

    public function show(string $id): ProjectActivityResource|JsonResponse
    {
        $activity = ProjectActivity::query()
            ->with('project')
            ->whereHas('project', fn ($q) => $q->where('status', 'active'))
            ->whereKey($id)
            ->first();

        if (!$activity) {
            return response()->json(['message' => 'Project activity not found.'], 404);
        }

        return new ProjectActivityResource($activity);
    }

    public function project(string $slug)
    {
        $activities = ProjectActivity::query()
            ->with('project')
            ->whereHas('project', function ($q) use ($slug) {
                $q->where('status', 'active')
                    ->where(function ($q) use ($slug) {
                        $q->where('slug_en', $slug)
                            ->orWhere('slug_bn', $slug);
                    });
            })
            ->orderBy('activity_date')
            ->orderBy('sort_order')
            ->latest('created_at')
            ->get();

        return ProjectActivityResource::collection($activities);
    }
}
