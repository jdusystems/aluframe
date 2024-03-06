<?php

namespace App\Models;

use App\Models\ProfileType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Corner extends Model
{
    use HasFactory , SoftDeletes;

    protected $table="corners";

    protected $fillable = [
        'name' , 'uz_name' ,'vendor_code' , 'price','profile_type_id'
    ];
    public function profileType(){
        return $this->belongsTo(ProfileType::class);
    }

}
