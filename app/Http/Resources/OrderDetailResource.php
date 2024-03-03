<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ShowProfileTypeResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'order_id' => ($this->order) ? $this->order_id : " ",
            'profile_type' => ($this->profileType) ? $this->profileType->name : " ",
            'profile_color' => ($this->profileColor) ? $this->profileColor->name : " ",
            'window_color' => ($this->windowColor) ? $this->windowColor->name : " ",
            'additional_service' => ($this->additionalService) ? $this->additionalService->name : " ",
            'assembly_service' => ($this->assemblyService) ? $this->assemblyService->name : " ",
            'opening_type' => ($this->openingType) ? $this->openingType->name : " ",
            'handler_type' => ($this->handlerPosition) ? $this->handlerPosition->name : " ",
            'width' => $this->width,
            'height' => $this->height,
            'quantity_right' => $this->quantity_right ,
            'quantity_left' => $this->quantity_left ,
            'corner_quantity' => $this->corner_quantity ,
            'sealant_quantity' => $this->sealant_quantity ,
            'window_handler_quantity' => $this->window_handler_quantity ,
            'number_of_loops' => $this->number_of_loops ,
            'price' => $this->price ,
            'comment' => $this->comment ,
            'additive_sizes' => $this->additive_sizes ,
            'handler_type_name' => $this->handler_type_name,
            'handler_type_name_uz' => $this->handler_type_name_uz,
        ];
    }
}
