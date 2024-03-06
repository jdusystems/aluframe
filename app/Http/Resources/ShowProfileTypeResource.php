<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProfileTypeResource extends JsonResource
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
            'image_name' => $this->image_name ,
            'image_url' => $this->image_url ,
            'name' => $this->name ,
            'vendor_code' => $this->vendor_code ,
            'uz_name' => $this->uz_name ,
            'size_name' => $this->size_name ,
            'thickness' => $this->thickness ,
            'price' => $this->price ,
            'sort_index' => $this->sort_index,
            'calculation_type_name' => ($this->calculationType) ? $this->calculationType->name :" ",
            'calculation_type_id' => ($this->calculationType) ? $this->calculationType->id :" ",
            'profile_colors' => ($this->profileColors) ? ShowProfileColorResource::collection($this->profileColors) : [] ,
        ];
    }
}
