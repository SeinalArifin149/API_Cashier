<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        $stock = Stock::all();
        return response()->json($stock);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id'    => 'required|exists:users,id',
            'type'       => 'required|string|max:255',
            'qty'        => 'required|numeric|min:0',
            'note'       => 'nullable|string'
        ]);

        $stock = Stock::create($validate);

        return response()->json([
            'status'  => 'success',
            'message' => 'Stock berhasil dimasukan',
            'data'    => $stock
        ], 201);
    }

    public function show($id)
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Stock tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $stock
        ]);
    }

    public function destroy($id)
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Stock tidak ditemukan'
            ], 404);
        }

        $stock->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Stock berhasil dihapus'
        ]);
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Stock tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id'    => 'required|exists:users,id',
            'type'       => 'required|string|max:255',
            'qty'        => 'required|numeric|min:0',
            'note'       => 'nullable|string'
        ]);

        $stock->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Stock berhasil diupdate',
            'data'    => $stock
        ]);
    }
}
