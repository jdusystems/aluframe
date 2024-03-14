<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\OrderDetail;
use App\Models\Status;
use App\Models\User;
class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'ordered_date' , 'order_id' , 'user_id' , 'status_id' , 'total_price' ,'active','currency_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }


}
