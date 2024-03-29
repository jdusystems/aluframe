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
            'id' => $this->id,
            'name' => $this->name ,
            'position' => $this->position ,
            'sort_index' => $this->sort_index ,
            'image_url' => $this->image_url ,
            'image_name' => $this->image_name ,
            'type_name' => ($this->type) ? $this->type->name : " ",
            'type_id' => ($this->type) ? $this->type->id : " " ,
            'handler_positions' =>  ($this->handlerPositions) ? ShowHandlerPositionResource::collection($this->handlerPositions) : " ",
        ];
    }
}
