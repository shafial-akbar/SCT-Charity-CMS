<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => [
                'en' => $this->title_en,
                'bn' => $this->title_bn,
            ],

            'slug' => [
                'en' => $this->slug_en,
                'bn' => $this->slug_bn,
            ],

            'short_description' => [
                'en' => $this->short_description_en,
                'bn' => $this->short_description_bn,
            ],

            'description' => [
                'en' => $this->description_en,
                'bn' => $this->description_bn,
            ],

            'featured_image' => $this->whenLoaded('featuredImage', function () {
                return $this->featuredImage ? [
                    'id' => $this->featuredImage->id,
                    'file_name' => $this->featuredImage->file_name,
                    'original_name' => $this->featuredImage->original_name,
                    'file_path' => $this->featuredImage->file_path,
                    'disk' => $this->featuredImage->disk,
                    'mime_type' => $this->featuredImage->mime_type,
                    'alt_text' => $this->featuredImage->alt_text,
                    'title' => $this->featuredImage->title,
                ] : null;
            }),

            'status' => $this->status,
            'sort_order' => $this->sort_order,

            'seo' => [
                'title' => [
                    'en' => $this->seo_title_en,
                    'bn' => $this->seo_title_bn,
                ],
                'description' => [
                    'en' => $this->seo_description_en,
                    'bn' => $this->seo_description_bn,
                ],
            ],

            'published_at' => $this->published_at?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
