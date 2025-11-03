<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Tambah User Baru</h2>
    </x-slot>

    <form action="{{ route('admin.users.store') }}" method="POST" class="max-w-md mx-auto py-6">
        @csrf

        <div>
            <label>Nama</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>

        <div class="mt-3">
            <label>Email</label>
            <input type="email" name="email" class="w-full border rounded p-2" required>
        </div>

        <div class="mt-3">
            <label>Password</label>
            <input type="password" name="password" class="w-full border rounded p-2" required>
        </div>

        <div class="mt-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
        </div>

        <div class="mt-3">
            <label>Role</label>
            <select name="role" class="w-full border rounded p-2" required>
                <option value="manager">Manager</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</x-app-layout>
