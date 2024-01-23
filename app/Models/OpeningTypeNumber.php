<?php

namespace App\Models;
use App\Models\OpeningType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
class OpeningTypeNumber extends Model
{
    use HasFactory;
    protected $fillable = [
        'opening_type_id'
    ];

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function openingType(){
        return $this->belongsTo(OpeningType::class);
    }


}
