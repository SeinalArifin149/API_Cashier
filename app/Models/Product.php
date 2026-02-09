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
        return $this->hasMany(Transaction_Detail::class);
    }

}
