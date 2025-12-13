<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Application Error') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    <h3 class="text-2xl font-bold text-red-500 mb-4">Unavailable</h3>
                    <p class="mb-4">The internal application is not responding.</p>
                    <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded text-left font-mono text-sm mb-4">
                        {{ $message }}
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-indigo-500 hover:text-indigo-400">Return to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>