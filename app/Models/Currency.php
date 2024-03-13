<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' , 'rate' , 'symbol' ,'active'
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
