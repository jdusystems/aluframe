<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OrderDetail;
use App\Models\WindowHandler;
class ProfileColor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["name" , "sort_index", "color_from", "color_to",'image_name' ,'image_url' , 'profile_type_id'];

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function windowHandlers(){
        return $this->hasMany(WindowHandler::class);
    }

    public function profileType(){
        return $this->belongsTo(ProfileType::class);
    }

    public function windowColors(){
        return $this->hasMany(WindowColor::class);
    }
}
