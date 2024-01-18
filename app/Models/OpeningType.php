<?php

namespace App\Models;
use App\Models\CalculationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningType extends Model
{
    use HasFactory;
    protected $table = "opening_types";
    protected $fillable = ['name' , 'type_id' , 'sort_index' , "image_url" ,"image_name", 'price'];


    public function calcType(){
        return $this->belongsTo(CalculationType::class);
    }
}
