<?php

namespace App\Models;
use App\Models\CalculationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;
use App\Models\OpeningTypeNumber;
class OpeningType extends Model
{
    use HasFactory;
    protected $table = "opening_types";
    protected $fillable = ['name' ,'position' , 'type_id' , 'sort_index' , "image_url" ,"image_name"];


    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }
    public function openingTypeNumbers(){
        return $this->hasMany(OpeningTypeNumber::class);
    }
    public function handlerPositions(){
        return $this->belongsToMany(HandlerPosition::class , 'handlerposition_openingtype')->orderBy('sort_index');
    }

}
