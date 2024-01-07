<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class ShowWindowColorResource extends JsonResource
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
            'name' => $this->name,
            'image_url' =>  route('image.get' , $this->image),
            'sort_index' => $this->sort_index,
            'vendor_code' => $this->vendor_code,
            'price' => $this->price,
        ];
    }
}
