<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ShowProfileTypeResource;
class ShowCornerResource extends JsonResource
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
            'name' => $this->name ,
            'uz_name' => $this->uz_name ,
            'vendor_code' => $this->vendor_code ,
            'price' => $this->price ,
            'profile_type_name' =>($this->profileType) ? $this->profileType->name :" " ,
            'profile_type_id' =>  ($this->profileType) ? $this->profileType->id : " " ,
        ];
    }
}
