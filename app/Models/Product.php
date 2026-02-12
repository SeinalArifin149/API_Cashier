<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table="products";

    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'price',
        'stock',
    ];
     public function trancationdetail() {
        return $this->hasMany(TransactionDetail::class);
    }
    public function stock() {
        return $this->hasMany(Stock::class);
    }
    public function categories() {
        return $this->belongsTo(Categories::class);
    }

    // public function product() {
    //     return $this->hasMany(Product::class).
    // }
    // public function product() {
    //     return $this->belongTo(Product::class).
    // }

}
