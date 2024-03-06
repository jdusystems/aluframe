<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandlerPositionType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' , 'name_uz'
    ];
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

}
