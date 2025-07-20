<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString(); // mantém filtros na paginação

        return view('admin.users.index', compact('users'));
    }


    public function promote(Request $request, User $user)
    {
        $user->update([
            'role' => 'admin',
        ]);

        return redirect()->route('admin.users')->with('success', 'Usuario promovido para Administrador.');
    }
}
