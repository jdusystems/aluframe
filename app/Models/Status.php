<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
class Status extends Model
{
    use HasFactory;
    protected $fillable = [
          'name' , 'slug' ,'color'
        ];
    public function orders(){
        return $this->hasMany(Order::class);
    }

}
