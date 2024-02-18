<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowAssemblyServiceResource extends JsonResource
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
            'name' => $this->name ,
            'uz_name' => $this->uz_name ,
            'vendor_code' => $this->vendor_code ,
            'condition_operator' => $this->condition_operator ,
            'facade_height' => $this->facade_height ,
            'price' => $this->price
        ];

    }
}
