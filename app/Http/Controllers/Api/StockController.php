<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    //
    public function index(){
        $stock= Stock::all();
        return response()->json(Stock::all());
    }

    public function store(request $request) {
        $validate = $request->validate (
            [
                'product_id' => 'required|exists:products_id',
                'user_id' => 'required|exists:users_id',
                'type' => 'required|string|max:255',
                'qty' => 'required|string|max:100|unique:Stocks,qty',
                'note' => 'required|numeric|min:0'
            ]);
            $stock = Stock::create($validate);

            return response()->json([
            'status'  => 'success',
            'message' => 'Stock berhasil di masukan',
            'data'    => $stock
            ], 201);
            }

    public function show($id) {
        $stock = Stock::find($id);

        if(!$stock){
            return response()->json([
                'status' => 'error',
                'message' => 'Stock tidak ditemukan'
            ],404);
        }
        }

    public function destroy($id){
        $stock = Stock::find($id);

        if(!$stock){
            return response()->json([
                'status' => 'error',
                'message' => 'Stock tidak ditemukan'
                ], 404);
                }

            
            $stock->delete($id);
            return response()->json ([
                    
                'status' => 'error',
                'message' => 'Stock berhasil dihapus'
            ]);
    }

     public function update(Request $request, $id)
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stock tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products_id',
                'name' => 'required|string|max:255',
                'qty' => 'required|string|max:100|unique:Stocks,qty',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|numeric|min:0'
        ]);

        $stock->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Stock berhasil diupdate',
            'data'    => $stock
        ]);
    }


}