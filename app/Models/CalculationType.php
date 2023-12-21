<?php

namespace App\Models;
use App\Models\OpeningType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculationType extends Model
{
    use HasFactory;
    protected $table = "calculation_types";
    protected $fillable = ['name'];

    public function openingTypes(){
        return $this->hasMany(OpeningType::class);
    }
}
