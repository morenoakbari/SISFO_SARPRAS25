<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        $admins = User::where('role', 'admin')->get();
        return view('dashboard.users', compact('users', 'admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,user',
            'password' => 'required|confirmed|min:6',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
    
        return redirect()->route('user.list')->with('success', 'User berhasil ditambahkan!');
    }
    
}
