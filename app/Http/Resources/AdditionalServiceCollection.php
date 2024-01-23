<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdditionalServiceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Additional Services List',
            'data' => $this->collection->map(function ($additionalService) {
                return new AdditionalServiceResource($additionalService);
            }),
        ];
    }
}
