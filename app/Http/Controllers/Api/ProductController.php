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
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'sku' => 'required|string|max:100|unique:products,sku',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|numeric|min:0'
            ]);
            $product = Product::create($validate);

            return response()->json([
            'status'  => 'success',
            'message' => 'Product berhasil di masukan',
            'data'    => $product
            ], 201);
            }

    public function show($id) {
        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'status' => 'error',
                'message' => 'product tidak ditemukan'
            ],404);
        }
        }
}