<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowOpeningTypeNumberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'opening_type_name' => ($this->openingType) ? $this->openingType->name : " " ,
            'numbers' =>  ($this->images) ? ShowImageResource::collection($this->images) : " ",
        ];
    }
}
