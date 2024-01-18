<?php

namespace App\Models;
use App\Models\ProfileType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WindowHandler extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name' , 'vendor_code' , 'price','profile_type_id'
    ];

    public function profileType(){
        return $this->belongsTo(ProfileType::class);
    }
}
