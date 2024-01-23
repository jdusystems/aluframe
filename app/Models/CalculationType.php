<?php

namespace App\Models;
use App\Models\OpeningType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalculationType extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "calculation_types";
    protected $fillable = ['name'];

    public function profiles(){
        return $this->hasMany(ProfileType::class);
    }
}
