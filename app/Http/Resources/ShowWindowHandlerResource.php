<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ShowProfileTypeResource;
class ShowWindowHandlerResource extends JsonResource
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
            'vendor_code' => $this->vendor_code ,
            'price' => $this->price ,
            'profile_type_name' =>($this->profileType) ? $this->profileType->name :" " ,
            'profile_type_id' =>  ($this->profileType) ? $this->profileType->id : " " ,
            'profile_color_id' =>  ($this->profileColor) ? $this->profileColor->id : " " ,
            'profile_color_name' =>  ($this->profileColor) ? $this->profileColor->name : " " ,
        ];
    }
}
