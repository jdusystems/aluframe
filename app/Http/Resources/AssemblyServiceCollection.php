<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssemblyServiceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Assembly Services List',
            'data' => $this->collection->map(function ($assemblyService) {
                return new ShowAssemblyServiceResource($assemblyService);
            }),
        ];
    }
}
