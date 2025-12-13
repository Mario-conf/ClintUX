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
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#f9f506",
                        "background-light": "#f8f8f5",
                        "background-dark": "#23220f",
                    },
                    fontFamily: {
                        "display": ["Spline Sans", "sans-serif"]
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
</head>

<body class="font-display bg-background-light dark:bg-background-dark text-[#181811] dark:text-white">
    <div class="flex min-h-screen w-full overflow-hidden">
        <!-- Left Side (Image) -->
        <div class="relative hidden lg:flex w-1/2 xl:w-[60%] flex-col bg-[#181811]">
            <div class="absolute inset-0 w-full h-full">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 hover:scale-105" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD3KHoJ6jEY1ff-uw5LrN9-Y6cqpRzIVknl2IfGEtK8Q1n5IMmwFBmYwDJT_Kzx5kmi4xCz04CUPjLO1KJ02T-wfddK1ygAY0W7d6BkU5Meqn6K6JYlqAbWJEPKXqWNf_WAO745IFgkpyFqvqpEPyZGqhfnMfw9-_ANNT6z9PhS0noibVT4OdfTT5C1fhFcnRw2iXxFVam-EeC6BHs98DYJTI63q6bhVcw_sBmKgorPF6fbmyJjgCKz3pqTNRrSTkYjdzkfVYaWzdg");'></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/20"></div>
                <div class="absolute top-0 right-0 w-2/3 h-2/3 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-primary/20 via-transparent to-transparent opacity-60"></div>
            </div>
            <div class="relative z-10 flex flex-col h-full justify-between p-12 xl:p-16">
                <div class="flex items-start">
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/10 shadow-xl">
                        <span class="material-symbols-outlined text-primary">admin_panel_settings</span>
                        <span class="text-sm font-bold text-white tracking-wide uppercase">{{ config('app.name') }} v2.4</span>
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
            <div class="absolute inset-0 lg:hidden z-0 opacity-5" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD3KHoJ6jEY1ff-uw5LrN9-Y6cqpRzIVknl2IfGEtK8Q1n5IMmwFBmYwDJT_Kzx5kmi4xCz04CUPjLO1KJ02T-wfddK1ygAY0W7d6BkU5Meqn6K6JYlqAbWJEPKXqWNf_WAO745IFgkpyFqvqpEPyZGqhfnMfw9-_ANNT6z9PhS0noibVT4OdfTT5C1fhFcnRw2iXxFVam-EeC6BHs98DYJTI63q6bhVcw_sBmKgorPF6fbmyJjgCKz3pqTNRrSTkYjdzkfVYaWzdg"); background-size: cover;'></div>

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
                        <span class="material-symbols-outlined text-primary text-xl">admin_panel_settings</span>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#181811] dark:text-white">{{ config('app.name') }}</span>
                    </div>
                    <h2 class="text-4xl font-bold text-[#181811] dark:text-white mb-3">Welcome back</h2>
                    <p class="text-[#8c8b5f] dark:text-[#cac99d] text-lg">Please enter your details to sign in.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
                    @csrf

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-[#181811] dark:text-gray-200 ml-1">Email Address</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                class="w-full h-14 bg-white dark:bg-[#363520] border border-[#e6e6db] dark:border-[#44432a] rounded-full px-6 text-base text-[#181811] dark:text-white placeholder:text-[#8c8b5f] dark:placeholder:text-[#848366] focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all shadow-sm"
                                placeholder="user@company.com" />
                            <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-[#8c8b5f]">mail</span>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-[#181811] dark:text-gray-200 ml-1">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full h-14 bg-white dark:bg-[#363520] border border-[#e6e6db] dark:border-[#44432a] rounded-full pl-6 pr-12 text-base text-[#181811] dark:text-white placeholder:text-[#8c8b5f] dark:placeholder:text-[#848366] focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all shadow-sm"
                                placeholder="••••••••" />
                            <!-- Toggle Visibility Script could be added here, simplified for now -->
                            <button class="absolute inset-y-0 right-4 flex items-center justify-center text-[#8c8b5f] hover:text-[#181811] dark:hover:text-white transition-colors cursor-pointer" type="button" onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';">
                                <span class="material-symbols-outlined" style="font-size: 20px;">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-3 cursor-pointer group select-none">
                            <div class="relative flex items-center justify-center w-5 h-5">
                                <input id="remember_me" type="checkbox" name="remember" class="peer appearance-none w-5 h-5 border-2 border-[#e6e6db] dark:border-[#6f6e4d] rounded bg-transparent checked:bg-primary checked:border-primary transition-all cursor-pointer" />
                                <span class="material-symbols-outlined absolute text-black text-sm opacity-0 peer-checked:opacity-100 font-bold pointer-events-none transform scale-75 transition-transform">check</span>
                            </div>
                            <span class="text-sm font-medium text-[#8c8b5f] dark:text-[#cac99d] group-hover:text-[#181811] dark:group-hover:text-white transition-colors">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                        <a class="text-sm font-bold text-[#181811] dark:text-white hover:text-primary underline decoration-transparent hover:decoration-primary decoration-2 underline-offset-4 transition-all" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full h-14 mt-4 bg-primary hover:bg-[#e3df05] text-black text-lg font-bold rounded-full shadow-lg shadow-primary/20 hover:shadow-primary/40 active:scale-[0.98] transition-all duration-200 tracking-wide flex items-center justify-center gap-2 group">
                        <span>Sign In</span>
                        <span class="material-symbols-outlined text-xl transition-transform group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-12 text-center border-t border-[#e6e6db] dark:border-[#44432a] pt-6">
                    <p class="text-sm text-[#8c8b5f] dark:text-[#cac99d]">
                        Having trouble? <a class="font-bold text-[#181811] dark:text-white hover:underline" href="#">Contact Support</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>