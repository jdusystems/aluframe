<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corner extends Model
{
    use HasFactory;

    protected $table="corners";

    protected $fillable = [
        'name' , 'vendor_code' , 'price'
    ];
}
