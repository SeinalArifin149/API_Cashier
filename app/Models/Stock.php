<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    protected $table='stock_logos';
    protected $fillable = [
        'product_id',
        'user_id',
        'qty',
        'note',

    ];
};