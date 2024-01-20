<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandlerType extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'slug'];
    protected $table = "handler_types";


    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

}
