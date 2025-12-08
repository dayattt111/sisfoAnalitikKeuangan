@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h3 class="text-2xl font-bold mb-6 text-gray-800">Edit Data User</h3>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Role</label>
                <select name="role" class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">
                    <strong>Catatan:</strong> Password tidak akan diubah. Jika ingin mengubah password, hubungi user untuk reset password melalui fitur lupa password.
                </p>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold transition">
                    💾 Update
                </button>
                <a href="{{ route('admin.users.index') }}" class="flex-1 bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 font-semibold text-center transition">
                    ⬅️ Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
