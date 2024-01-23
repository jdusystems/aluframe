<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProfileColorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Profile colors list',
            'data' => $this->collection->map(function ($profileColor) {
                return new ShowProfileColorResource($profileColor);
            }),
        ];
    }
}
