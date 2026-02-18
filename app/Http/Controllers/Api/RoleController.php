<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('users')->get();

        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        $role = Role::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Role berhasil dibuat',
            'data'    => $role
        ], 201);
    }

    public function show($id)
    {
        $role = Role::with('users')->find($id);

        if (!$role) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Role tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $role
        ]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Role tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        $role->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Role berhasil diupdate',
            'data'    => $role
        ]);
    }

    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Role tidak ditemukan'
            ], 404);
        }

        $role->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Role berhasil dihapus'
        ]);
    }
}
