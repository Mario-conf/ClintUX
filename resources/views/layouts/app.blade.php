<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ Auth::user()?->theme ?? (session('theme', 'light')) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&amp;family=Noto+Sans:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet" />

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#FF5100",
                        /* Orange */
                        "secondary": "#CD9C8A",
                        /* Dark Beige/Clay */
                        "neutral": "#DDD0C8",
                        /* Light Beige */

                        /* Light Theme */
                        "background-light": "#FDFBF7",
                        /* Off-white / Blanco Roto */
                        "surface-light": "#FFFFFF",
                        "border-light": "#DDD0C8",
                        /* Beige Borders */

                        /* Dark Theme */
                        "background-dark": "#121212",
                        /* Black */
                        "surface-dark": "#1E1E1E",
                        /* Dark Gray Surface */
                        "border-dark": "#323232",
                        /* Charcoal Borders */

                        /* Brand Accents */
                        "charcoal": "#323232",
                    },
                    fontFamily: {
                        "display": ["Spline Sans", "sans-serif"],
                        "body": ["Noto Sans", "sans-serif"],
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "2xl": "1.5rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    @vite(['resources/js/app.js'])
</head>

<body class="bg-background-light dark:bg-background-dark text-[#181811] dark:text-[#e6e6db] font-display antialiased min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 bg-surface-light dark:bg-surface-dark border-b border-border-light dark:border-border-dark px-6 py-4 shadow-sm relative">
        <div class="max-w-[1400px] mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4 text-[#181811] dark:text-[#f9f506]">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 hover:opacity-80 transition-opacity">
                    <div class="size-8 text-primary">
                        <svg class="w-full h-full" fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path>
                            <path clip-rule="evenodd" d="M10.4485 13.8519C10.4749 13.9271 10.6203 14.246 11.379 14.7361C12.298 15.3298 13.7492 15.9145 15.6717 16.3735C18.0007 16.9296 20.8712 17.2655 24 17.2655C27.1288 17.2655 29.9993 16.9296 32.3283 16.3735C34.2508 15.9145 35.702 15.3298 36.621 14.7361C37.3796 14.246 37.5251 13.9271 37.5515 13.8519C37.5287 13.7876 37.4333 13.5973 37.0635 13.2931C36.5266 12.8516 35.6288 12.3647 34.343 11.9175C31.79 11.0295 28.1333 10.4437 24 10.4437C19.8667 10.4437 16.2099 11.0295 13.657 11.9175C12.3712 12.3647 11.4734 12.8516 10.9365 13.2931C10.5667 13.5973 10.4713 13.7876 10.4485 13.8519ZM37.5563 18.7877C36.3176 19.3925 34.8502 19.8839 33.2571 20.2642C30.5836 20.9025 27.3973 21.2655 24 21.2655C20.6027 21.2655 17.4164 20.9025 14.7429 20.2642C13.1498 19.8839 11.6824 19.3925 10.4436 18.7877V34.1275C10.4515 34.1545 10.5427 34.4867 11.379 35.027C12.298 35.6207 13.7492 36.2054 15.6717 36.6644C18.0007 37.2205 20.8712 37.5564 24 37.5564C27.1288 37.5564 29.9993 37.2205 32.3283 36.6644C34.2508 36.2054 35.702 35.6207 36.621 35.027C37.4573 34.4867 37.5485 34.1546 37.5563 34.1275V18.7877ZM41.5563 13.8546V34.1455C41.5563 36.1078 40.158 37.5042 38.7915 38.3869C37.3498 39.3182 35.4192 40.0389 33.2571 40.5551C30.5836 41.1934 27.3973 41.5564 24 41.5564C20.6027 41.5564 17.4164 41.1934 14.7429 40.5551C12.5808 40.0389 10.6502 39.3182 9.20848 38.3869C7.84205 37.5042 6.44365 36.1078 6.44365 34.1455L6.44365 13.8546C6.44365 12.2684 7.37223 11.0454 8.39581 10.2036C9.43325 9.3505 10.8137 8.67141 12.343 8.13948C15.4203 7.06909 19.5418 6.44366 24 6.44366C28.4582 6.44366 32.5797 7.06909 35.657 8.13948C37.1863 8.67141 38.5667 9.3505 39.6042 10.2036C40.6278 11.0454 41.5563 12.2684 41.5563 13.8546Z" fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-[#181811] dark:text-white text-xl font-bold leading-tight tracking-[-0.015em]">{{ config('app.name') }}</h2>
                </a>
            </div>
            <div class="flex items-center gap-8">
                <nav class="hidden md:flex items-center gap-6">
                    <a class="text-[#181811] dark:text-white text-sm {{ request()->routeIs('dashboard') ? 'font-bold border-b-2 border-primary' : 'font-medium opacity-70 hover:opacity-100 hover:text-primary' }} leading-normal py-1 transition-all" href="{{ route('dashboard') }}">Dashboard</a>
                    @if(Auth::user()->isAdmin())
                    <a class="text-[#181811] dark:text-white text-sm {{ request()->routeIs('admin.apps.*') ? 'font-bold border-b-2 border-primary' : 'font-medium opacity-70 hover:opacity-100 hover:text-primary' }} leading-normal py-1 transition-all" href="{{ route('admin.apps.index') }}">Apps</a>
                    <a class="text-[#181811] dark:text-white text-sm {{ request()->routeIs('admin.users.*') ? 'font-bold border-b-2 border-primary' : 'font-medium opacity-70 hover:opacity-100 hover:text-primary' }} leading-normal py-1 transition-all" href="{{ route('admin.users.index') }}">Users</a>
                    <a class="text-[#181811] dark:text-white text-sm {{ request()->routeIs('admin.audits.*') ? 'font-bold border-b-2 border-primary' : 'font-medium opacity-70 hover:opacity-100 hover:text-primary' }} leading-normal py-1 transition-all" href="{{ route('admin.audits.index') }}">Logs</a>
                    @endif
                </nav>
                <div class="flex items-center gap-3">
                    <!-- Theme Toggle -->
                    <button
                        x-data="{ darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
                        x-init="$watch('darkMode', val => { 
                            localStorage.setItem('theme', val ? 'dark' : 'light');
                            if(val) document.documentElement.classList.add('dark');
                            else document.documentElement.classList.remove('dark');
                        })"
                        @click="darkMode = !darkMode"
                        class="size-10 rounded-full flex items-center justify-center text-gray-400 hover:text-primary transition-colors bg-gray-50 dark:bg-white/5"
                        :title="darkMode ? 'Switch to Light' : 'Switch to Dark'">
                        <span class="material-symbols-outlined text-[22px]" x-show="!darkMode">light_mode</span>
                        <span class="material-symbols-outlined text-[22px]" x-show="darkMode" style="display: none;">dark_mode</span>
                    </button>

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity" title="Edit Profile">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold dark:text-white">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 border-2 border-border-light dark:border-border-dark flex items-center justify-center bg-surface-light text-primary font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500" title="Logout">
                            <span class="material-symbols-outlined">logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 w-full max-w-[1400px] mx-auto p-6 md:p-8 flex flex-col gap-8">
        {{ $slot }}
    </main>
</body>

</html>