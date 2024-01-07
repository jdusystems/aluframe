<?php

namespace App\Models;
use App\Models\CalculationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningType extends Model
{
    use HasFactory;
    protected $table = "opening_types";
    protected $fillable = ['name' , 'calculation_type' , 'sort_index' , 'image' , 'price'];

}
