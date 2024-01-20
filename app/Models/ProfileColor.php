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

    protected $fillable = ["name" , "sort_index", "color_from", "color_to"];

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function windowHandlers(){
        return $this->hasMany(WindowHandler::class);
    }
}
