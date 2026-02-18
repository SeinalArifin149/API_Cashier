<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use App\Models\Product;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with(['user', 'product'])->latest()->get();

        return response()->json($stocks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id'    => 'required|exists:users,id',
            'type'       => 'required|in:in,out',
            'qty'        => 'required|numeric|min:1',
            'note'       => 'nullable|string'
        ]);

        return DB::transaction(function () use ($validated) {

            $product = Product::findOrFail($validated['product_id']);

            // Kalau stock keluar
            if ($validated['type'] === 'out') {
                if ($product->stock < $validated['qty']) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Stock tidak mencukupi'
                    ], 400);
                }

                $product->decrement('stock', $validated['qty']);
            }

            // Kalau stock masuk
            if ($validated['type'] === 'in') {
                $product->increment('stock', $validated['qty']);
            }

            $stock = Stock::create($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Stock berhasil dicatat',
                'data'    => $stock
            ], 201);
        });
    }

    public function show($id)
    {
        $stock = Stock::with(['user', 'product'])->find($id);

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
            'type' => 'required|in:in,out',
            'qty'  => 'required|numeric|min:1',
            'note' => 'nullable|string'
        ]);

        $stock->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Stock berhasil diupdate',
            'data'    => $stock
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
}
