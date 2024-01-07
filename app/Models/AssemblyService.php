<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssemblyService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' , 'condition_operator' , 'facade_height' , 'vendor_code' , 'price'
    ];
}
