@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-xl mx-auto">
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ $user->name }}"
                   class="w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md p-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ $user->email }}"
                   class="w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md p-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Role</label>
            <select name="role" class="w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md p-2">
                <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2 hover:bg-gray-400 transition">Kembali</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Update</button>
        </div>
    </form>
</div>
@endsection
