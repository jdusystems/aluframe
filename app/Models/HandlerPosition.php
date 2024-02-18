<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandlerPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' , 'uz_name' , 'image_name' , 'image_url' , 'sort_index' , 'slug'
    ];

    public function openingTypes(){
        return $this->belongsToMany(OpeningType::class , 'handlerposition_openingtype');
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }


}
