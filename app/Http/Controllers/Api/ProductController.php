<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|max:100|unique:products,sku',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:0'
        ]);

        $product = Product::create($validate);

        return response()->json([
            'status'  => 'success',
            'message' => 'Product berhasil dimasukan',
            'data'    => $product
        ], 201);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product tidak ditemukan'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product berhasil dihapus'
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|max:100|unique:products,sku,' . $id,
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:0'
        ]);

        $product->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Product berhasil diupdate',
            'data'    => $product
        ]);
    }
}
