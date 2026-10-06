<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            'id' => $this->id,

            'title' => [
                'en' => $this->title_en,
                'bn' => $this->title_bn,
            ],

            'slug' => [
                'en' => $this->slug_en,
                'bn' => $this->slug_bn,
            ],


            /*
            |--------------------------------------------------------------------------
            | Program Content
            |--------------------------------------------------------------------------
            */

            'short_description' => [
                'en' => $this->short_description_en,
                'bn' => $this->short_description_bn,
            ],

            'description' => [
                'en' => $this->description_en,
                'bn' => $this->description_bn,
            ],


            /*
            |--------------------------------------------------------------------------
            | Featured Image
            |--------------------------------------------------------------------------
            */

            'featured_image' => $this->whenLoaded(
                'featuredImage',
                function () {
                    $media = $this->featuredImage;

                    if (!$media) {
                        return null;
                    }

                    return [
                        'id' => $media->id,

                        'file_name' => $media->file_name,

                        'original_name' => $media->original_name,

                        'file_path' => $media->file_path,

                        'url' => Storage::disk($media->disk)
                            ->url($media->file_path),

                        'disk' => $media->disk,

                        'mime_type' => $media->mime_type,

                        'file_size' => $media->file_size,

                        'alt_text' => [
                            'en' => $media->alt_text_en,
                            'bn' => $media->alt_text_bn,
                        ],

                        'title' => [
                            'en' => $media->title_en,
                            'bn' => $media->title_bn,
                        ],

                        'caption' => [
                            'en' => $media->caption_en,
                            'bn' => $media->caption_bn,
                        ],
                    ];
                }
            ),


            /*
            |--------------------------------------------------------------------------
            | Publishing
            |--------------------------------------------------------------------------
            */

            'status' => $this->status,

            'sort_order' => $this->sort_order,

            'published_at' => $this->published_at?->toISOString(),


            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            'created_at' => $this->created_at?->toISOString(),

            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}