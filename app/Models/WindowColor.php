<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OrderDetail;
class WindowColor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["profile_color_id" ,'active' , "name", 'uz_name' , "image_url" ,"image_name", "second_image_url" ,"second_image_name", "sort_index", "vendor_code", "price"];


    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }
    public function profileColor(){
        return $this->belongsTo(ProfileColor::class);
    }
}
