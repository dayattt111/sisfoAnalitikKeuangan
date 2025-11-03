@extends('layouts.admin')

@section('title', 'Tambah User Baru')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-xl mx-auto">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="name" class="w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" class="w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md p-2" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">Role</label>
            <select name="role" class="w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md p-2" required>
                <option value="manager">Manager</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2 hover:bg-gray-400 transition">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
