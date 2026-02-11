<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index(){
        $user= User::all();
        return response()->json(User::all());
    }

    public function store(request $request) {
        $validate = $request->validate (
            [
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => ['required', Password::min(6)],
                'role'     => 'required|in:admin,kasir,gudang',
            ]);
            $user= User::create($validate);

            return response()->json([
            'status'  => 'success',
            'message' => 'User berhasil dibuat',
            'data'    => $user
            ], 201);
            
        

    }


    public function show($id) {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan'
            ],404);
        }

        return response()->json([
            'status' => 'success',
            'data'=> $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => ['sometimes', Password::min(6)],
            'role'  => 'sometimes|in:admin,kasir,gudang',
        ]);

        $user->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'User berhasil diupdate',
            'data'    => $user
        ]);
    }

    public function destroy($id){
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan'
                ], 404);
                }

            
            $user->delete($id);
            return response()->json ([
                    
                'status' => 'error',
                'message' => 'User berhasil dihapus'
            ]);
    }
}
