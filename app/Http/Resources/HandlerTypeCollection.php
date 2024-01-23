<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class HandlerTypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Handler types list',
            'data' => $this->collection->map(function ($handlerType) {
                return new ShowHandlerTypeResource($handlerType);
            }),
        ];
    }
}
