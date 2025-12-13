<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Expired - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
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
                        "background-light": "#FDFBF7",
                        "background-dark": "#121212",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1E1E1E",
                        "border-light": "#DDD0C8",
                        "border-dark": "#323232",
                    },
                    fontFamily: {
                        "display": ["Spline Sans", "sans-serif"],
                    },
                },
            },
        }
    </script>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-[#181811] dark:text-white overflow-hidden relative selection:bg-blue-500 selection:text-white">

    <!-- Background Decoration (Blue Tint for Info/Expiry) -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('{{ asset('img/login-bg.png') }}')] bg-cover bg-center opacity-5"></div>
        <div class="absolute top-0 right-0 w-2/3 h-2/3 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-500/10 via-transparent to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-1/2 h-1/2 bg-[radial-gradient(ellipse_at_bottom_left,_var(--tw-gradient-stops))] from-primary/5 via-transparent to-transparent"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center p-6">
        <div class="w-full max-w-lg">
            <!-- Glass Card -->
            <div class="backdrop-blur-xl bg-surface-light/80 dark:bg-surface-dark/80 border border-white/20 dark:border-white/10 rounded-2xl shadow-2xl overflow-hidden p-8 md:p-12 text-center relative">
                
                <!-- Decoration Circle -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/20 blur-3xl rounded-full pointer-events-none"></div>

                <!-- Error Code -->
                <h1 class="text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-indigo-500 mb-2 leading-none selection:bg-transparent">
                    419
                </h1>

                <!-- Message -->
                <h2 class="text-2xl font-bold mb-4">Page Expired</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-8 text-lg font-light leading-relaxed">
                    Your session has expired due to inactivity. Please sign in again to continue.
                </p>

                <!-- Action -->
                <div class="flex flex-col gap-3">
                    <a href="{{ route('login') }}" class="w-full py-3 px-6 rounded-lg bg-primary hover:bg-orange-600 text-white font-bold shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all active:scale-[0.98] flex items-center justify-center gap-2 group">
                        <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">login</span>
                        Sign In Again
                    </a>
                </div>

                <!-- Footer -->
                <div class="mt-8 pt-6 border-t border-border-light dark:border-border-dark">
                    <p class="text-xs text-center text-gray-400 uppercase tracking-widest font-bold">
                        Error Code: 419
                    </p>
                </div>
            </div>
            
            <!-- Branding Footer -->
            <div class="mt-8 text-center opacity-60 hover:opacity-100 transition-opacity">
                <p class="text-sm font-medium">Powered by <span class="font-bold text-primary">ClintUX</span></p>
            </div>
        </div>
    </div>

</body>
</html>