<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    protected $table='stock_logs';
    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'qty',
        'note',

    ];
     public function user() {
        return $this->belongsTo(User::class);
    }
      public function product() {
        return $this->belongsTo(Product::class);
    } 
    // public function stock() {
    //     return $this->hasMany(Stock::class);
    // }
    
};