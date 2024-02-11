<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ShowOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        return [
            'id' => $this->id,
            'order_id' => $this->order_id ,
            'client_name' => ($this->user) ? $this->user->name : " " ,
            'client_phone_number' => ($this->user) ? $this->user->phone_number : " " ,
            'status' => ($this->status) ? $this->status->name : " ",
            'status_color' => ($this->status) ? $this->status->color : " ",
            'status_id' => ($this->status) ? $this->status->id : " ",
            'total_price' => ($user->superadmin==1 || $user->is_admin == 0) ? $this->total_price : 0,
            'ordered_time' => $this->created_at,
            'order_details' => OrderDetailResource::collection($this->orderDetails) ,
        ];
    }
}
