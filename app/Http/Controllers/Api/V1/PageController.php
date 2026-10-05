<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $pages = Page::with(['sections.media','parent'])
            ->where('status','published')
            ->when($request->filled('parent_slug'), function ($q) use ($request) {
                $parent = Page::where('slug', $request->string('parent_slug'))->first();
                $q->where('parent_id', $parent?->id);
            })
            ->orderBy('sort_order')->paginate(min((int)$request->input('per_page',15),50));

        return PageResource::collection($pages);
    }

    public function show(string $slug): PageResource
    {
        $page = Page::with(['sections.media','parent','children'])
            ->where('slug',$slug)->where('status','published')->firstOrFail();

        return new PageResource($page);
    }
}
