<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandlerPositionType extends Model
{
    use HasFactory;
    protected $fillable = [
        'handler_type_name' , 'handler_type_name_uz'
    ];
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

}
