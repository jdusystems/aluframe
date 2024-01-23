<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CalculationTypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'message' => "All calculation types list" ,
            'data' => $this->collection->map(function ($calculationType){
                return new CalculationTypeResource($calculationType);
            }),
        ];
    }
}
