<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nama</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="border-gray-300 rounded-md w-full">
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="border-gray-300 rounded-md w-full">
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm text-gray-700">Role</label>
                        <select name="role" class="border-gray-300 rounded-md w-full">
                            <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded-md">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
