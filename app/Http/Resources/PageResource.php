<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => [
                'en' => $this->title_en,
                'bn' => $this->title_bn,
            ],

            'slug' => $this->slug,
            'page_type' => $this->page_type,

            'short_description' => [
                'en' => $this->short_description_en,
                'bn' => $this->short_description_bn,
            ],

            'status' => $this->status,

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

            'sort_order' => $this->sort_order,
            'published_at' => $this->published_at,

            'parent' => $this->whenLoaded('parent', function () {
                return [
                    'id' => $this->parent?->id,
                    'title' => [
                        'en' => $this->parent?->title_en,
                        'bn' => $this->parent?->title_bn,
                    ],
                    'slug' => $this->parent?->slug,
                ];
            }),

            'children' => $this->whenLoaded('children', function () {
                return $this->children->map(function ($child) {
                    return [
                        'id' => $child->id,
                        'title' => [
                            'en' => $child->title_en,
                            'bn' => $child->title_bn,
                        ],
                        'slug' => $child->slug,
                        'page_type' => $child->page_type,
                    ];
                });
            }),

            'sections' => PageSectionResource::collection(
                $this->whenLoaded('sections')
            ),
        ];
    }
}