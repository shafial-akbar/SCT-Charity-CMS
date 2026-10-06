<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;
use App\Models\Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Get all published programs.
     */
    public function index(Request $request)
    {
        $perPage = min(
            max($request->integer('per_page', 12), 1),
            50
        );

        $programs = Program::query()
            ->with('featuredImage')
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->paginate($perPage);

        return ProgramResource::collection($programs);
    }

    /**
     * Get a single published program by English or Bangla slug.
     */
    public function show(string $slug): ProgramResource|JsonResponse
    {
        $program = Program::query()
            ->with('featuredImage')
            ->where('status', 'published')
            ->where(function ($query) use ($slug) {
                $query->where('slug_en', $slug)
                    ->orWhere('slug_bn', $slug);
            })
            ->first();

        if (!$program) {
            return response()->json([
                'message' => 'Program not found.',
            ], 404);
        }

        return new ProgramResource($program);
    }
}