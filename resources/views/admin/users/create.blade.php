@extends('layouts.admin')

@section('title', 'Tambah User Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h3 class="text-2xl font-bold mb-6 text-gray-800">Tambah User Baru</h3>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                       placeholder="Masukkan nama lengkap" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                       placeholder="email@example.com" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password" 
                       class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                       placeholder="Minimal 6 karakter" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" 
                       class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                       placeholder="Ulangi password" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Role</label>
                <select name="role" class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold transition">
                    💾 Simpan
                </button>
                <a href="{{ route('admin.users.index') }}" class="flex-1 bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 font-semibold text-center transition">
                    ❌ Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
