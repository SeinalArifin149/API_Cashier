<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\Product;

class TransactionDetailController extends Controller
{
    public function index()
    {
        $details = TransactionDetail::with(['trancation', 'product'])->get();

        return response()->json($details);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transactions_id' => 'required|exists:transactions,id',
            'product_id'      => 'required|exists:products,id',
            'qty'             => 'required|numeric|min:1',
        ]);

        // Ambil harga product otomatis
        $product = Product::find($validated['product_id']);

        $validated['price'] = $product->price;
        $validated['subtotal'] = $validated['qty'] * $validated['price'];

        $detail = TransactionDetail::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail transaksi berhasil ditambahkan',
            'data'    => $detail
        ], 201);
    }

    public function show($id)
    {
        $detail = TransactionDetail::with(['trancation', 'product'])->find($id);

        if (!$detail) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Detail transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $detail
        ]);
    }

    public function update(Request $request, $id)
    {
        $detail = TransactionDetail::find($id);

        if (!$detail) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Detail transaksi tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'qty' => 'required|numeric|min:1',
        ]);

        // Hitung ulang subtotal
        $validated['price'] = $detail->price;
        $validated['subtotal'] = $validated['qty'] * $validated['price'];

        $detail->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail transaksi berhasil diupdate',
            'data'    => $detail
        ]);
    }

    public function destroy($id)
    {
        $detail = TransactionDetail::find($id);

        if (!$detail) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Detail transaksi tidak ditemukan'
            ], 404);
        }

        $detail->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail transaksi berhasil dihapus'
        ]);
    }
}
