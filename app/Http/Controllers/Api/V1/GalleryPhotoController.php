<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryPhotoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = min(max((int) $request->input('per_page', 24), 1), 100);

        $photos = GalleryPhoto::query()
            ->whereHas('gallery', function ($q) {
                $q->where('status', 'published')
                  ->where(function ($q) {
                      $q->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                  });
            })
            ->with(['gallery', 'media'])
            ->orderBy('sort_order')
            ->paginate($perPage);

        return response()->json([
            'data' => $photos->getCollection()->map(
                fn (GalleryPhoto $photo) => $this->transform($photo)
            )->values(),
            'meta' => [
                'current_page' => $photos->currentPage(),
                'last_page' => $photos->lastPage(),
                'per_page' => $photos->perPage(),
                'total' => $photos->total(),
            ],
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $photo = GalleryPhoto::query()
            ->whereHas('gallery', function ($q) {
                $q->where('status', 'published')
                  ->where(function ($q) {
                      $q->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                  });
            })
            ->with(['gallery', 'media'])
            ->findOrFail($id);

        return response()->json([
            'data' => $this->transform($photo),
        ]);
    }

    public function gallery(string $slug): JsonResponse
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
            ->firstOrFail();

        $photos = $gallery->photos()
            ->with('media')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'data' => $photos->map(
                fn (GalleryPhoto $photo) => $this->transform($photo, false)
            )->values(),
            'gallery' => [
                'id' => $gallery->id,
                'title_en' => $gallery->title_en,
                'title_bn' => $gallery->title_bn,
                'slug_en' => $gallery->slug_en,
                'slug_bn' => $gallery->slug_bn,
            ],
        ]);
    }

    private function transform(GalleryPhoto $photo, bool $includeGallery = true): array
    {
        $data = [
            'id' => $photo->id,
            'caption_en' => $photo->caption_en,
            'caption_bn' => $photo->caption_bn,
            'alt_text_en' => $photo->alt_text_en,
            'alt_text_bn' => $photo->alt_text_bn,
            'sort_order' => $photo->sort_order,
            'image' => $this->media($photo->media),
        ];

        if ($includeGallery && $photo->gallery) {
            $data['gallery'] = [
                'id' => $photo->gallery->id,
                'title_en' => $photo->gallery->title_en,
                'title_bn' => $photo->gallery->title_bn,
                'slug_en' => $photo->gallery->slug_en,
                'slug_bn' => $photo->gallery->slug_bn,
            ];
        }

        return $data;
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
