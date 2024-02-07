<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowOrderResource extends JsonResource
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
            'order_id' => $this->order_id ,
            'client_name' => ($this->user) ? $this->user->name : " " ,
            'client_phone_number' => ($this->user) ? $this->user->phone_number : " " ,
            'status' => ($this->status) ? $this->status->name : " ",
            'status_id' => ($this->status) ? $this->status->id : " ",
            'total_price' => $this->total_price ,
            'ordered_time' => $this->created_at,
            'order_details' => OrderDetailResource::collection($this->orderDetails) ,
        ];
    }
}
