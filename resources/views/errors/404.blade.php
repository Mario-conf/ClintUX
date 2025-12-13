<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg border border-gray-200 dark:border-gray-700 relative">

            <!-- Glassmorphism Effect -->
            <div class="absolute inset-0 bg-white/5 dark:bg-black/20 backdrop-blur-sm z-0"></div>

            <div class="relative z-10 text-center">
                <h1 class="text-9xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
                    404
                </h1>

                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-4">
                    Page Not Found
                </h2>

                <p class="mt-4 text-gray-600 dark:text-gray-400">
                    Oops! The page you are looking for does not exist. It might have been moved or deleted.
                </p>

                <div class="mt-8">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        {{ __('Return to Dashboard') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>