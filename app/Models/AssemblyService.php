<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;
class AssemblyService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' , 'uz_name' , 'condition_operator' , 'facade_height' , 'vendor_code' , 'price'
    ];

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }
}
