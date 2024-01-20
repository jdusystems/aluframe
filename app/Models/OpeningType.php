<?php

namespace App\Models;
use App\Models\CalculationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;
class OpeningType extends Model
{
    use HasFactory;
    protected $table = "opening_types";
    protected $fillable = ['name' , 'type_id' , 'sort_index' , "image_url" ,"image_name"];


    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }
}
