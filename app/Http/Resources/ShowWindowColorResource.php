<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class ShowWindowColorResource extends JsonResource
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
            'second_image_url' => $this->second_image_url ,
            'second_image_name' => $this->second_image_name ,
            'sort_index' => $this->sort_index,
            'vendor_code' => $this->vendor_code,
            'price' => $this->price,
            'profile_color_name' => ($this->profileColor) ? $this->profileColor->name : "" ,
            'profile_color_id' => ($this->profileColor) ? $this->profileColor->id : "" ,
            'profile_type_name' => ($this->profileColor->profileType) ? $this->profileColor->profileType->name : "" ,
            'profile_type_id' => ($this->profileColor->profileType) ? $this->profileColor->profileType->id : "" ,
        ];
    }
}
