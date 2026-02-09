<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function Laravel\Prompts\table;

class Transaction_Detail extends Model
{
    //
    protected $table = 'transaction_details';
    protected $fillable = [
        'transactions_id',
        'product_id',
        'qty',
        'price',
        'subtotal',
    ];

    public function trancation() {
        return $this->belongsTo(Transaction::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
    
}
