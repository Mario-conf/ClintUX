<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

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
                        "primary": "#f9f506",
                        "background-light": "#f8f8f5",
                        "background-dark": "#23220f",
                        "card-dark": "#2d2c1b",
                        "input-dark": "#3a3821",
                        "surface-light": "#ffffff",
                        "surface-dark": "#2f2e16",
                        "border-light": "#e6e6db",
                        "border-dark": "#4a4825",
                    },
                    fontFamily: {
                        "display": ["Spline Sans", "sans-serif"],
                        "body": ["Noto Sans", "sans-serif"],
                    },
                    borderRadius: {
                        "DEFAULT": "1rem",
                        "lg": "2rem",
                        "xl": "3rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white overflow-x-hidden antialiased">
    <div class="flex h-screen w-full overflow-hidden">
        <!-- Sidebar -->
        <aside class="hidden w-64 flex-col border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-background-dark lg:flex">
            <div class="flex h-20 items-center gap-3 px-8">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-black">
                    <span class="material-symbols-outlined">admin_panel_settings</span>
                </div>
                <div>
                    <h1 class="text-base font-bold leading-none text-slate-900 dark:text-white">{{ config('app.name') }}</h1>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Admin Panel</p>
                </div>
            </div>
            <nav class="flex-1 space-y-2 px-4 py-6">
                <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-primary text-black shadow-sm ring-1 ring-black/5 font-bold' : 'text-slate-600 hover:bg-gray-50 dark:text-slate-300 dark:hover:bg-white/5 transition-colors' }}" href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('dashboard') ? 'font-semibold' : '' }}">dashboard</span>
                    Dashboard
                </a>
                <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.apps.*') ? 'bg-primary text-black shadow-sm ring-1 ring-black/5 font-bold' : 'text-slate-600 hover:bg-gray-50 dark:text-slate-300 dark:hover:bg-white/5 transition-colors' }}" href="{{ route('admin.apps.index') }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.apps.*') ? 'font-semibold' : '' }}">apps</span>
                    Apps
                </a>
                <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-primary text-black shadow-sm ring-1 ring-black/5 font-bold' : 'text-slate-600 hover:bg-gray-50 dark:text-slate-300 dark:hover:bg-white/5 transition-colors' }}" href="#">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.users.*') ? 'font-semibold' : '' }}">group</span>
                    Users
                </a>
                <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.audits.*') ? 'bg-primary text-black shadow-sm ring-1 ring-black/5 font-bold' : 'text-slate-600 hover:bg-gray-50 dark:text-slate-300 dark:hover:bg-white/5 transition-colors' }}" href="{{ route('admin.audits.index') }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.audits.*') ? 'font-semibold' : '' }}">description</span>
                    Logs
                </a>
            </nav>
            <div class="p-4">
                <div class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-3 dark:border-gray-800 dark:bg-white/5">
                    <div class="h-10 w-10 rounded-full bg-surface-light dark:bg-surface-dark flex items-center justify-center text-primary font-bold border-2 border-border-light dark:border-border-dark">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="truncate text-sm font-bold text-slate-900 dark:text-white">{{ Auth::user()->name }}</p>
                        <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                        @csrf
                        <button class="flex h-8 w-8 items-center justify-center rounded-full text-slate-400 hover:bg-white hover:shadow-sm dark:hover:bg-white/10" title="Logout">
                            <span class="material-symbols-outlined text-[20px]">logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex flex-1 flex-col overflow-y-auto bg-background-light dark:bg-background-dark">
            <div class="container mx-auto max-w-6xl px-6 py-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>