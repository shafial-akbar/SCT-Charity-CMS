<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project' => $this->whenLoaded('project', fn () => [
                'id' => $this->project?->id,
                'title' => [
                    'en' => $this->project?->title_en,
                    'bn' => $this->project?->title_bn,
                ],
                'slug' => [
                    'en' => $this->project?->slug_en,
                    'bn' => $this->project?->slug_bn,
                ],
                'status' => $this->project?->status,
            ]),
            'title' => [
                'en' => $this->title_en,
                'bn' => $this->title_bn,
            ],
            'description' => [
                'en' => $this->description_en,
                'bn' => $this->description_bn,
            ],
            'activity_date' => $this->activity_date?->toDateString(),
            'location' => [
                'en' => $this->location_en,
                'bn' => $this->location_bn,
            ],
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
