<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::all();
        return response()->json($transaction);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id'    => 'required|exists:users,id',
            'total'       => 'required|string|max:255',
            'qty'        => 'required|numeric|min:0',
            'note'       => 'nullable|string'
        ]);

        $transaction = transaction::create($validate);

        return response()->json([
            'status'  => 'success',
            'message' => 'transaction berhasil dimasukan',
            'data'    => $transaction
        ], 201);
    }

    public function show($id)
    {
        $transaction = transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status'  => 'error',
                'message' => 'transaction tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $transaction
        ]);
    }

    public function destroy($id)
    {
        $transaction = transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status'  => 'error',
                'message' => 'transaction tidak ditemukan'
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'transaction berhasil dihapus'
        ]);
    }

    public function update(Request $request, $id)
    {
        $transaction = transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status'  => 'error',
                'message' => 'transaction tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id'    => 'required|exists:users,id',
            'type'       => 'required|string|max:255',
            'qty'        => 'required|numeric|min:0',
            'note'       => 'nullable|string'
        ]);

        $transaction->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'transaction berhasil diupdate',
            'data'    => $transaction
        ]);
    }
}