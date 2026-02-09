<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    //
    protected $table = 'transactions';
    protected $fillable = [
        'total',
        'paid',
        'change',
    ];
   public function user() {
        return $this->belongsTo(User::class);
    }
   public function trancationdetail() {
        return $this->hasMany(Transaction_Detail::class);
    }
    
}
