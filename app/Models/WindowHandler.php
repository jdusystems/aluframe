<?php

namespace App\Models;
use App\Models\ProfileType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProfileColor;
class WindowHandler extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name' , 'name_uz' , 'vendor_code' , 'price','profile_type_id','profile_color_id'
    ];

    public function profileType(){
        return $this->belongsTo(ProfileType::class);
    }
    public function profileColor(){
        return $this->belongsTo(ProfileColor::class);
    }
}
