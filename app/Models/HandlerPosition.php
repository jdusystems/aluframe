<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandlerPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' , 'image_name' , 'image_url' , 'sort_index'
    ];

    public function openingTypes(){
        return $this->belongsToMany(OpeningType::class , 'handlerposition_openingtype');
    }
}
