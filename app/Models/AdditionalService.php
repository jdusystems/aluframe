<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OrderDetail;
class AdditionalService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["name", 'uz_name' , 'uz_description' , "image_url" ,"image_name", "sort_index", "vendor_code", "price" ,'description'];

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }
}
