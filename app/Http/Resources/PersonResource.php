<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Schema;

class PersonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'designation' => [
                'en' => $this->designation_en,
                'bn' => $this->designation_bn,
            ],
            'biography' => [
                'en' => $this->biography_en,
                'bn' => $this->biography_bn,
            ],
            'message' => [
                'en' => $this->message_en,
                'bn' => $this->message_bn,
            ],
            'photo' => $this->photo ? [
                'id' => $this->photo->id,
                'url' => asset('storage/' . ltrim($this->photo->file_path, '/')),
                'alt_text' => [
                    'en' => $this->photo->alt_text_en,
                    'bn' => $this->photo->alt_text_bn,
                ],
            ] : null,
            'email' => $this->email,
            'phone' => $this->phone,
            'social_links' => $this->social_links,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if (Schema::hasColumn('people', 'slug_en')) {
            $data['slug_en'] = $this->slug_en;
        }

        if (Schema::hasColumn('people', 'slug_bn')) {
            $data['slug_bn'] = $this->slug_bn;
        }

        return $data;
    }
}
