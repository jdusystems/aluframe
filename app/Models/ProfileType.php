<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OrderDetail;

class ProfileType extends Model
{
    use HasFactory , CascadeSoftDeletes , SoftDeletes;

    protected $cascadeDeletes = ['sealant' , 'window_handler' ,'corner'];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name' , 'calculation_type_id' , 'price' , 'sort_index'
    ];
    protected $table = "profile_types";

    public function sealant(){
        return $this->hasOne(Sealant::class);
    }
    public function window_handler(){
        return $this->hasOne(WindowHandler::class);
    }
    public function corner(){
        return $this->hasOne(Corner::class);
    }

    public function calculationType(){
        return $this->belongsTo(CalculationType::class);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }




}
