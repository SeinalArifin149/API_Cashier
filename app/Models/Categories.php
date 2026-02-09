<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //
    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];
    public function product() {
        return $this->hasMany(Product::class);
    }

}
// Schema::create('categories', function (Blueprint $table) {
//             $table->id();
//             $table->string('name');
//             $table->timestamps();
//         });