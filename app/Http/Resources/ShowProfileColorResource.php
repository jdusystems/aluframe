<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProfileColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'uz_name' => $this->uz_name,
            'image_name' => $this->image_name,
            'image_url' => $this->image_url,
            'sort_index' => $this->sort_index,
            'color_from' => $this->color_from,
            'color_to' => $this->color_to,
            'profile_type_name' => $this->profileType->name,
            'profile_type_id' => $this->profileType->id ,
            'window_colors' => ($this->windowColors) ? ShowWindowColorResource::collection($this->windowColors) : [] ,
        ];
    }
}
