<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Menampilkan semua user (khusus admin)
     */
    public function index()
    {
        $users = User::latest()->get();

        return response()->json([
            'status'  => true,
            'message' => 'Daftar semua user',
            'data'    => $users
        ], Response::HTTP_OK);
    }

    /**
     * Update role user (khusus admin)
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,seller,customer'
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Role user berhasil diperbarui',
            'data'    => $user
        ], Response::HTTP_OK);
    }
}
