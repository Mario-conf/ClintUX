<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet" />
    <script>
        // Init Dark Mode
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#FF5100",
                        /* Orange */
                        "secondary": "#CD9C8A",
                        "neutral": "#DDD0C8",
                        "background-light": "#FDFBF7",
                        "background-dark": "#121212",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1E1E1E",
                        "border-light": "#DDD0C8",
                        "border-dark": "#323232",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"] /* Inter matched with admin */
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
    <!-- Use Inter font to match Admin -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
</head>

<body class="font-display bg-background-light dark:bg-background-dark text-[#181811] dark:text-white">
    <div class="flex min-h-screen w-full overflow-hidden">
        <!-- Left Side (Image) -->
        <div class="relative hidden lg:flex w-1/2 xl:w-[60%] flex-col bg-[#181811]">
            <div class="absolute inset-0 w-full h-full">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 hover:scale-105" style='background-image: url("{{ asset("img/login-bg.png") }}");'></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/20"></div>
                <div class="absolute top-0 right-0 w-2/3 h-2/3 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-primary/20 via-transparent to-transparent opacity-60"></div>
            </div>
            <div class="relative z-10 flex flex-col h-full justify-between p-12 xl:p-16">
                <div class="flex items-start">
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/10 shadow-xl">
                        <div class="size-5 text-primary">
                            <svg class="w-full h-full" fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path>
                                <path clip-rule="evenodd" d="M10.4485 13.8519C10.4749 13.9271 10.6203 14.246 11.379 14.7361C12.298 15.3298 13.7492 15.9145 15.6717 16.3735C18.0007 16.9296 20.8712 17.2655 24 17.2655C27.1288 17.2655 29.9993 16.9296 32.3283 16.3735C34.2508 15.9145 35.702 15.3298 36.621 14.7361C37.3796 14.246 37.5251 13.9271 37.5515 13.8519C37.5287 13.7876 37.4333 13.5973 37.0635 13.2931C36.5266 12.8516 35.6288 12.3647 34.343 11.9175C31.79 11.0295 28.1333 10.4437 24 10.4437C19.8667 10.4437 16.2099 11.0295 13.657 11.9175C12.3712 12.3647 11.4734 12.8516 10.9365 13.2931C10.5667 13.5973 10.4713 13.7876 10.4485 13.8519ZM37.5563 18.7877C36.3176 19.3925 34.8502 19.8839 33.2571 20.2642C30.5836 20.9025 27.3973 21.2655 24 21.2655C20.6027 21.2655 17.4164 20.9025 14.7429 20.2642C13.1498 19.8839 11.6824 19.3925 10.4436 18.7877V34.1275C10.4515 34.1545 10.5427 34.4867 11.379 35.027C12.298 35.6207 13.7492 36.2054 15.6717 36.6644C18.0007 37.2205 20.8712 37.5564 24 37.5564C27.1288 37.5564 29.9993 37.2205 32.3283 36.6644C34.2508 36.2054 35.702 35.6207 36.621 35.027C37.4573 34.4867 37.5485 34.1546 37.5563 34.1275V18.7877ZM41.5563 13.8546V34.1455C41.5563 36.1078 40.158 37.5042 38.7915 38.3869C37.3498 39.3182 35.4192 40.0389 33.2571 40.5551C30.5836 41.1934 27.3973 41.5564 24 41.5564C20.6027 41.5564 17.4164 41.1934 14.7429 40.5551C12.5808 40.0389 10.6502 39.3182 9.20848 38.3869C7.84205 37.5042 6.44365 36.1078 6.44365 34.1455L6.44365 13.8546C6.44365 12.2684 7.37223 11.0454 8.39581 10.2036C9.43325 9.3505 10.8137 8.67141 12.343 8.13948C15.4203 7.06909 19.5418 6.44366 24 6.44366C28.4582 6.44366 32.5797 7.06909 35.657 8.13948C37.1863 8.67141 38.5667 9.3505 39.6042 10.2036C40.6278 11.0454 41.5563 12.2684 41.5563 13.8546Z" fill="currentColor" fill-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-white tracking-wide uppercase">{{ config('app.name') }}</span>
                    </div>
                </div>
                <div class="max-w-2xl">
                    <h1 class="text-5xl xl:text-6xl font-bold text-white leading-tight mb-6 drop-shadow-lg">
                        Secure Access for <br />
                        <span class="text-primary">Enterprise Control</span>
                    </h1>
                    <p class="text-gray-300 text-lg xl:text-xl font-light leading-relaxed max-w-lg mb-8">
                        Authenticate to access the centralized management dashboard. Monitor performance, manage users, and secure your infrastructure.
                    </p>
                    <div class="flex gap-8 border-t border-white/10 pt-8">
                        <div>
                            <p class="text-primary font-bold text-2xl">99.9%</p>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mt-1">Uptime</p>
                        </div>
                        <div>
                            <p class="text-primary font-bold text-2xl">Secure</p>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mt-1">Protocol</p>
                        </div>
                        <div>
                            <p class="text-primary font-bold text-2xl">24/7</p>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mt-1">Monitoring</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side (Form) -->
        <div class="flex w-full lg:w-1/2 xl:w-[40%] flex-col items-center justify-center p-8 lg:p-12 xl:p-24 bg-background-light dark:bg-background-dark relative">
            <div class="absolute inset-0 lg:hidden z-0 opacity-5" style='background-image: url("{{ asset("img/login-bg.png") }}"); background-size: cover;'></div>

            <div class="w-full max-w-md relative z-10">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                @if ($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400">
                    <div class="font-medium text-sm">
                        {{ __('Whoops! Something went wrong.') }}
                    </div>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="mb-10 text-center lg:text-left">
                    <div class="inline-flex lg:hidden items-center gap-2 mb-6 bg-primary/10 px-3 py-1.5 rounded-lg">
                        <div class="size-5 text-primary">
                            <!-- Mobile Logo -->
                            <svg class="w-full h-full" fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path>
                                <path clip-rule="evenodd" d="M10.4485 13.8519C10.4749 13.9271 10.6203 14.246 11.379 14.7361C12.298 15.3298 13.7492 15.9145 15.6717 16.3735C18.0007 16.9296 20.8712 17.2655 24 17.2655C27.1288 17.2655 29.9993 16.9296 32.3283 16.3735C34.2508 15.9145 35.702 15.3298 36.621 14.7361C37.3796 14.246 37.5251 13.9271 37.5515 13.8519C37.5287 13.7876 37.4333 13.5973 37.0635 13.2931C36.5266 12.8516 35.6288 12.3647 34.343 11.9175C31.79 11.0295 28.1333 10.4437 24 10.4437C19.8667 10.4437 16.2099 11.0295 13.657 11.9175C12.3712 12.3647 11.4734 12.8516 10.9365 13.2931C10.5667 13.5973 10.4713 13.7876 10.4485 13.8519ZM37.5563 18.7877C36.3176 19.3925 34.8502 19.8839 33.2571 20.2642C30.5836 20.9025 27.3973 21.2655 24 21.2655C20.6027 21.2655 17.4164 20.9025 14.7429 20.2642C13.1498 19.8839 11.6824 19.3925 10.4436 18.7877V34.1275C10.4515 34.1545 10.5427 34.4867 11.379 35.027C12.298 35.6207 13.7492 36.2054 15.6717 36.6644C18.0007 37.2205 20.8712 37.5564 24 37.5564C27.1288 37.5564 29.9993 37.2205 32.3283 36.6644C34.2508 36.2054 35.702 35.6207 36.621 35.027C37.4573 34.4867 37.5485 34.1546 37.5563 34.1275V18.7877ZM41.5563 13.8546V34.1455C41.5563 36.1078 40.158 37.5042 38.7915 38.3869C37.3498 39.3182 35.4192 40.0389 33.2571 40.5551C30.5836 41.1934 27.3973 41.5564 24 41.5564C20.6027 41.5564 17.4164 41.1934 14.7429 40.5551C12.5808 40.0389 10.6502 39.3182 9.20848 38.3869C7.84205 37.5042 6.44365 36.1078 6.44365 34.1455L6.44365 13.8546C6.44365 12.2684 7.37223 11.0454 8.39581 10.2036C9.43325 9.3505 10.8137 8.67141 12.343 8.13948C15.4203 7.06909 19.5418 6.44366 24 6.44366C28.4582 6.44366 32.5797 7.06909 35.657 8.13948C37.1863 8.67141 38.5667 9.3505 39.6042 10.2036C40.6278 11.0454 41.5563 12.2684 41.5563 13.8546Z" fill="currentColor" fill-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#181811] dark:text-white">{{ config('app.name') }}</span>
                    </div>
                    <h2 class="text-3xl font-bold text-[#181811] dark:text-white mb-2">Welcome back</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Please enter your details to sign in.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
                    @csrf

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-[#181811] dark:text-gray-200 ml-1">Email Address</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                class="w-full h-12 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-lg px-4 pl-11 text-sm text-[#181811] dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all shadow-sm"
                                placeholder="user@company.com" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-gray-400 text-[20px]">mail</span>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-[#181811] dark:text-gray-200 ml-1">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full h-12 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-lg px-4 pl-11 pr-11 text-sm text-[#181811] dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all shadow-sm"
                                placeholder="••••••••" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-gray-400 text-[20px]">lock</span>
                            </div>
                            <button class="absolute inset-y-0 right-0 pr-3 flex items-center justify-center text-gray-400 hover:text-primary transition-colors cursor-pointer" type="button" onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-3 cursor-pointer group select-none">
                            <div class="relative flex items-center justify-center w-5 h-5">
                                <input id="remember_me" type="checkbox" name="remember" class="peer appearance-none w-5 h-5 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-surface-dark checked:bg-primary checked:border-primary transition-all cursor-pointer" />
                                <span class="material-symbols-outlined absolute text-white text-sm opacity-0 peer-checked:opacity-100 font-bold pointer-events-none transform scale-75 transition-transform">check</span>
                            </div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400 group-hover:text-primary transition-colors">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                        <a class="text-sm font-bold text-[#181811] dark:text-white hover:text-primary underline decoration-transparent hover:decoration-primary decoration-2 underline-offset-4 transition-all" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full h-12 mt-4 bg-primary hover:bg-[#ff6a00] text-white text-sm font-bold rounded-lg shadow-lg shadow-primary/20 hover:shadow-primary/40 active:scale-[0.98] transition-all duration-200 tracking-wide flex items-center justify-center gap-2 group">
                        <span>Sign In</span>
                        <span class="material-symbols-outlined text-[20px] transition-transform group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-12 text-center border-t border-[#e6e6db] dark:border-[#44432a] pt-6">
                    <p class="text-sm text-[#8c8b5f] dark:text-[#cac99d]">
                        Developed by <a class="font-bold text-[#181811] dark:text-white hover:underline" href="https://github.com/Mario-conf" target="_blank">Mario.conf</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>