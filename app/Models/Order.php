<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\OrderDetail;
use App\Models\Status;
class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'ordered_date' , 'order_id' , 'client_id' , 'status_id' , 'total_price' ,
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }


}
