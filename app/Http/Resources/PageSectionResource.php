<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'section_type' => $this->section_type,

            'title' => [
                'en' => $this->title_en,
                'bn' => $this->title_bn,
            ],

            'subtitle' => [
                'en' => $this->subtitle_en,
                'bn' => $this->subtitle_bn,
            ],

            'content' => [
                'en' => $this->content_en,
                'bn' => $this->content_bn,
            ],

            'media' => $this->whenLoaded('media', function () {
                if (!$this->media) {
                    return null;
                }

                return [
                    'id' => $this->media->id,
                    'file_name' => $this->media->file_name,
                    'original_name' => $this->media->original_name,
                    'file_path' => $this->media->file_path,
                    'disk' => $this->media->disk,
                    'mime_type' => $this->media->mime_type,
                    'alt_text' => $this->media->alt_text,
                    'title' => $this->media->title,
                    'caption' => $this->media->caption,
                ];
            }),

            'data' => $this->data,

            'sort_order' => $this->sort_order,
            'status' => $this->status,
        ];
    }
}