<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $perPage=min(max($request->integer('per_page',12),1),50);
        $projects=Project::query()->with(['program','featuredImage'])
            ->where('status','active')->orderBy('start_date')->latest('published_at')
            ->paginate($perPage);
        return ProjectResource::collection($projects);
    }

    public function show(string $slug): ProjectResource|JsonResponse
    {
        $project=Project::query()->with(['program','featuredImage'])
            ->where('status','active')
            ->where(fn($q)=>$q->where('slug_en',$slug)->orWhere('slug_bn',$slug))
            ->first();

        if(!$project) return response()->json(['message'=>'Project not found.'],404);
        return new ProjectResource($project);
    }
}
