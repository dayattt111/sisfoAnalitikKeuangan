@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Selamat datang, {{ Auth::user()->name }} 👋</h2>
        <p class="text-gray-700">
            Anda login sebagai <strong>{{ Auth::user()->role }}</strong>.
        </p>

        <div class="mt-6">
            <a href="{{ route('admin.users.index') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                👥 Kelola User
            </a>
        </div>
    </div>
@endsection
