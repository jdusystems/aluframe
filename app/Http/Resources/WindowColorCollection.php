<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WindowColorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Window colors list',
            'data' => $this->collection->map(function ($windowColor) {
                return new ShowWindowColorResource($windowColor);
            }),
        ];
    }
}
