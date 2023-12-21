<?php

namespace App\Models;
use App\Models\CalculationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningType extends Model
{
    use HasFactory;
    protected $table = "opening_types";
    protected $fillable = ['name' , 'calculation_type_id' , 'sort_index'];
    public function calculationType(){
        return $this->belongsTo(CalculationType::class);
    }
}
