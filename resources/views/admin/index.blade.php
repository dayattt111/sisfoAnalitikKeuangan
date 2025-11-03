<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- {{ __('Dashboard') }} --}}
        </h2>
                <a href="{{ route('users.index') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-200">
                        👥 Kelola User
                    </a>
    </x-slot>

    <div class="py-12">
        gfcjhbklmk;
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- <div class="p-6 text-gray-900 dark:text-gray-100">
                    ini dashboard kamu adalah seorang dengan role : {{ $name }}
                    {{ __("You're logged in!") }}
                </div> --}}
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                    <p>{{ __("You're logged in!") }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
