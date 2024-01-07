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
            'name' => $this->name ,
            'vendor_code' => $this->vendor_code ,
            'condition_operator' => $this->condition_operator ,
            'facade_height' => $this->facade_height ,
            'price' => $this->price
        ];

    }
}
