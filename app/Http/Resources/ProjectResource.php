<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'program'=>$this->whenLoaded('program',fn()=>[
                'id'=>$this->program?->id,
                'title'=>['en'=>$this->program?->title_en,'bn'=>$this->program?->title_bn],
                'slug'=>['en'=>$this->program?->slug_en,'bn'=>$this->program?->slug_bn],
            ]),
            'title'=>['en'=>$this->title_en,'bn'=>$this->title_bn],
            'slug'=>['en'=>$this->slug_en,'bn'=>$this->slug_bn],
            'short_description'=>['en'=>$this->short_description_en,'bn'=>$this->short_description_bn],
            'description'=>['en'=>$this->description_en,'bn'=>$this->description_bn],
            'featured_image'=>$this->whenLoaded('featuredImage',function(){
                $m=$this->featuredImage;
                if(!$m) return null;
                return [
                    'id'=>$m->id,'file_name'=>$m->file_name,'original_name'=>$m->original_name,
                    'file_path'=>$m->file_path,
                    'url'=>Storage::disk($m->disk)->url($m->file_path),
                    'disk'=>$m->disk,'mime_type'=>$m->mime_type,'file_size'=>$m->file_size,
                    'alt_text'=>['en'=>$m->alt_text_en,'bn'=>$m->alt_text_bn],
                    'title'=>['en'=>$m->title_en,'bn'=>$m->title_bn],
                    'caption'=>['en'=>$m->caption_en,'bn'=>$m->caption_bn],
                ];
            }),
            'location'=>['en'=>$this->location_en,'bn'=>$this->location_bn],
            'start_date'=>$this->start_date?->toDateString(),
            'end_date'=>$this->end_date?->toDateString(),
            'status'=>$this->status,
            'seo'=>[
                'title'=>['en'=>$this->seo_title_en,'bn'=>$this->seo_title_bn],
                'description'=>['en'=>$this->seo_description_en,'bn'=>$this->seo_description_bn],
            ],
            'published_at'=>$this->published_at?->toISOString(),
            'created_at'=>$this->created_at?->toISOString(),
            'updated_at'=>$this->updated_at?->toISOString(),
        ];
    }
}
