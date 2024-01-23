<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OpeningTypeNumber;
class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_name' , 'image_url' ,'opening_type_number_id' , 'number'
    ];

    public function openingTypeNumber(){
        return $this->belongsTo(OpeningTypeNumber::class);
    }
}
