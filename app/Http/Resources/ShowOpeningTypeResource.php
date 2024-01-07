<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowOpeningTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name ,
            'calculation_type'  => $this->calculation_type,
            'sort_index' => $this->sort_index ,
            'image_url' => route('image.get' , $this->image) ,
            'price' => $this->price ,
        ];
    }
}
