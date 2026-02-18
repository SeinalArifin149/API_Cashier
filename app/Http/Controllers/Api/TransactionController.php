<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'trancationdetail'])->get();

        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total'   => 'required|numeric|min:0',
            'paid'    => 'required|numeric|min:0',
        ]);

        // Hitung kembalian otomatis
        $validated['change'] = $validated['paid'] - $validated['total'];

        if ($validated['change'] < 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Uang bayar kurang'
            ], 400);
        }

        $transaction = Transaction::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Transaction berhasil dibuat',
            'data'    => $transaction
        ], 201);
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'trancationdetail'])->find($id);

        if (!$transaction) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Transaction tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $transaction
        ]);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Transaction tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'total' => 'required|numeric|min:0',
            'paid'  => 'required|numeric|min:0',
        ]);

        $validated['change'] = $validated['paid'] - $validated['total'];

        if ($validated['change'] < 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Uang bayar kurang'
            ], 400);
        }

        $transaction->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Transaction berhasil diupdate',
            'data'    => $transaction
        ]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Transaction tidak ditemukan'
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Transaction berhasil dihapus'
        ]);
    }
}
