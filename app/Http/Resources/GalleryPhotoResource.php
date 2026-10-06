<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GalleryPhotoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $media = $this->media;

        return [
            'id' => $this->id,
            'gallery' => $this->whenLoaded('gallery', fn () => [
                'id' => $this->gallery?->id,
                'title' => [
                    'en' => $this->gallery?->title_en,
                    'bn' => $this->gallery?->title_bn,
                ],
                'slug' => [
                    'en' => $this->gallery?->slug_en,
                    'bn' => $this->gallery?->slug_bn,
                ],
                'status' => $this->gallery?->status,
            ]),
            'image' => $media ? [
                'id' => $media->id,
                'file_name' => $media->file_name,
                'original_name' => $media->original_name,
                'file_path' => $media->file_path,
                'url' => Storage::disk($media->disk)->url($media->file_path),
                'disk' => $media->disk,
                'mime_type' => $media->mime_type,
                'file_size' => $media->file_size,
            ] : null,
            'caption' => [
                'en' => $this->caption_en,
                'bn' => $this->caption_bn,
            ],
            'alt_text' => [
                'en' => $this->alt_text_en,
                'bn' => $this->alt_text_bn,
            ],
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
