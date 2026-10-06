<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = min(max((int) $request->input('per_page', 12), 1), 50);

        $query = Gallery::query()
            ->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            ->with([
                'category',
                'coverImage',
                'photos' => fn ($q) => $q->orderBy('sort_order')->with('media'),
            ])
            ->orderByDesc('published_at')
            ->orderByDesc('created_at');

        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug_en', $category)
                  ->orWhere('slug_bn', $category);
            });
        }

        $galleries = $query->paginate($perPage);

        return response()->json([
            'data' => $galleries->getCollection()->map(
                fn (Gallery $gallery) => $this->transform($gallery)
            )->values(),
            'meta' => [
                'current_page' => $galleries->currentPage(),
                'last_page' => $galleries->lastPage(),
                'per_page' => $galleries->perPage(),
                'total' => $galleries->total(),
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $gallery = Gallery::query()
            ->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            ->where(function ($q) use ($slug) {
                $q->where('slug_en', $slug)
                  ->orWhere('slug_bn', $slug);
            })
            ->with([
                'category',
                'coverImage',
                'photos' => fn ($q) => $q->orderBy('sort_order')->with('media'),
            ])
            ->firstOrFail();

        return response()->json([
            'data' => $this->transform($gallery),
        ]);
    }

    private function transform(Gallery $gallery): array
    {
        return [
            'id' => $gallery->id,
            'title_en' => $gallery->title_en,
            'title_bn' => $gallery->title_bn,
            'slug_en' => $gallery->slug_en,
            'slug_bn' => $gallery->slug_bn,
            'description_en' => $gallery->description_en,
            'description_bn' => $gallery->description_bn,
            'status' => $gallery->status,
            'published_at' => $gallery->published_at?->toISOString(),
            'category' => $gallery->category ? [
                'id' => $gallery->category->id,
                'name_en' => $gallery->category->name_en,
                'name_bn' => $gallery->category->name_bn,
                'slug_en' => $gallery->category->slug_en,
                'slug_bn' => $gallery->category->slug_bn,
            ] : null,
            'cover_image' => $this->media($gallery->coverImage),
            'photos' => $gallery->photos->map(fn ($photo) => [
                'id' => $photo->id,
                'caption_en' => $photo->caption_en,
                'caption_bn' => $photo->caption_bn,
                'alt_text_en' => $photo->alt_text_en,
                'alt_text_bn' => $photo->alt_text_bn,
                'sort_order' => $photo->sort_order,
                'image' => $this->media($photo->media),
            ])->values(),
        ];
    }

    private function media($media): ?array
    {
        if (!$media) {
            return null;
        }

        return [
            'id' => $media->id,
            'url' => asset('storage/' . ltrim($media->file_path, '/')),
            'file_name' => $media->file_name,
            'original_name' => $media->original_name,
            'mime_type' => $media->mime_type,
            'file_size' => $media->file_size,
            'alt_text_en' => $media->alt_text_en,
            'alt_text_bn' => $media->alt_text_bn,
            'title_en' => $media->title_en,
            'title_bn' => $media->title_bn,
            'caption_en' => $media->caption_en,
            'caption_bn' => $media->caption_bn,
        ];
    }
}
