<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function index(){
        $product= Product::all();
        return response()->json(Product::all());
    }

    public function store(request $request) {
        $validate = $request->validate (
            [
                
            ]);
            $product = Product::create($validate);

            return response()->json([
            'status'  => 'success',
            'message' => 'User berhasil dibuat',
            'data'    => $product
            ], 201);
            
        

    }
}
