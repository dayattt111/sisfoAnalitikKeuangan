@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-2">Selamat datang, {{ Auth::user()->name }} 👋</h2>
        <p class="text-blue-100">
            Anda login sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong>
        </p>
    </div>

    {{-- Statistik Card --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Total User</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Total Admin</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalAdmin }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Total Manager</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalManager }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Total Staff</h3>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalStaff }}</p>
        </div>
    </div>

    {{-- Fitur Utama --}}
    {{-- <div class="bg-white p-6 rounded-lg shadow mt-8">
        <h3 class="text-lg font-semibold mb-4">Fitur</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-lg transition">
                👥 Kelola User
            </a>
        </div>
    </div> --}}
</div>
@endsection
