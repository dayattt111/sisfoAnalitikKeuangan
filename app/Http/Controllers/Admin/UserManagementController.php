<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();
        
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Admin melihat daftar user management',
        ]);
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,manager,staff',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menambahkan user baru: ' . $user->name . ' (' . $user->role . ')',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,manager,staff',
        ]);

        $oldData = $user->name . ' - ' . $user->role;
        $user->update($request->only('name', 'email', 'role'));

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Memperbarui data user dari [' . $oldData . '] menjadi [' . $user->name . ' - ' . $user->role . ']',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $userName = $user->name;
        $userRole = $user->role;
        
        $user->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menghapus user: ' . $userName . ' (' . $userRole . ')',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
