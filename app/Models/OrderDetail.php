<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\ProfileType;
use App\Models\WindowColor;
use App\Models\ProfileColor;
use App\Models\AdditionalService;
use App\Models\AssemblyService;
use App\Models\OpeningType;
use App\Models\HandlerType;
class OrderDetail extends Model
{
    use HasFactory;

    protected $table = "order_details";
    protected $fillable = [
        'order_id' , 'profile_type_id' , 'window_color_id' ,'profile_color_id',
        'additional_service_id' , 'assembly_service_id' , 'opening_type_id' ,
        'handler_type_id' , 'width' ,'height' ,'quantity_right' ,'quantity_left' ,'number_of_loops' ,'comment' ,
        'price' ,'X1' , 'X2' ,'Y1' , 'sealant_quantity' ,
        'corner_quantity' ,'window_handler_quantity' ,'handler_position_id' ,
        'profile_length' , 'sealant_length' , 'surface' , 'facade_quantity' , 'corner_quantity' , 'handler_type_name' , 'handler_type_name_uz'
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function profileType(){
        return $this->belongsTo(ProfileType::class);
    }

    public function windowColor(){
        return $this->belongsTo(WindowColor::class);
    }

    public function profileColor(){
        return $this->belongsTo(ProfileColor::class);
    }

    public function additionalService(){
        return $this->belongsTo(AdditionalService::class);
    }

    public function assemblyService(){
        return $this->belongsTo(AssemblyService::class);
    }
    public function openingType(){
        return $this->belongsTo(OpeningType::class);
    }

    public function handlerType(){
        return $this->belongsTo(HandlerType::class);
    }

    public function handlerPosition(){
     return $this->belongsTo(HandlerPosition::class);
    }


}
