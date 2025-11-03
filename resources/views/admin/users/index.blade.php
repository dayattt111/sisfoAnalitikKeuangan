<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Manajemen User</h2>
    </x-slot>

    <div class="py-6">
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah User</a>

        <table class="w-full mt-4 border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Role</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="border p-2">{{ $user->name }}</td>
                        <td class="border p-2">{{ $user->email }}</td>
                        <td class="border p-2">{{ ucfirst($user->role) }}</td>
                        <td class="border p-2 text-center">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600">Edit</a> |
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Hapus user ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
