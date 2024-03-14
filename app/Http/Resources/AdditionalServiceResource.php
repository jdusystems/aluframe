<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdditionalServiceResource extends JsonResource
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
            'image_url' => $this->image_url ,
            'image_name' => $this->image_name ,
            'sort_index' => $this->sort_index ,
            'vendor_code' => $this->vendor_code ,
            'price' => $this->price ,
            'description' => $this->description ,
            'uz_description' => $this->uz_description ,
        ];
    }
}
