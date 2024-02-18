<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProfileType;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sealant extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name', 'uz_name' , 'vendor_code' , 'price' ,'profile_type_id'
    ];

    public function profileType(){
        return $this->belongsTo(ProfileType::class);
    }
}
