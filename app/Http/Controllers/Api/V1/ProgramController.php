<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $programs = Program::query()
            ->with('featuredImage')
            ->where('status', 'published')
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->string('search')->toString();
                $q->where(function ($q) use ($search) {
                    $q->where('title_en', 'like', "%{$search}%")
                        ->orWhere('title_bn', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->latest()
            ->paginate(min((int) $request->input('per_page', 15), 50));

        return ProgramResource::collection($programs);
    }

    public function show(string $slug)
    {
        $program = Program::with('featuredImage')
            ->where('status', 'published')
            ->where(function ($q) use ($slug) {
                $q->where('slug_en', $slug)
                    ->orWhere('slug_bn', $slug);
            })
            ->firstOrFail();

        return new ProgramResource($program);
    }
}
