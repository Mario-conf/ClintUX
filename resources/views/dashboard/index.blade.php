<x-app-layout>
    <!-- Stats Row -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- CPU -->
        <div class="flex flex-col gap-3 rounded-xl p-5 border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm">
            <div class="flex justify-between items-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal">CPU Load</p>
                <span class="material-symbols-outlined text-primary">memory</span>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-[#181811] dark:text-white text-3xl font-bold leading-tight">{{ $stats['cpu_percent'] ?? 0 }}%</p>
                <!-- Trend placeholder (optional) -->
                <!-- <span class="text-xs text-green-600 font-medium flex items-center"><span class="material-symbols-outlined text-[14px]">trending_down</span> -2%</span> -->
            </div>
            <div class="w-full bg-background-light dark:bg-[#1f1e0e] rounded-full h-1.5 mt-2">
                <div class="bg-primary h-1.5 rounded-full" style="width: {{ $stats['cpu_percent'] ?? 0 }}%"></div>
            </div>
        </div>
        <!-- RAM -->
        <div class="flex flex-col gap-3 rounded-xl p-5 border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm">
            <div class="flex justify-between items-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal">RAM Usage</p>
                <span class="material-symbols-outlined text-primary">storage</span>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-[#181811] dark:text-white text-3xl font-bold leading-tight">{{ $stats['memory_percent'] ?? 0 }}%</p>
                <p class="text-xs text-gray-400">Total: 100%</p>
            </div>
            <div class="w-full bg-background-light dark:bg-[#1f1e0e] rounded-full h-1.5 mt-2">
                <div class="bg-primary h-1.5 rounded-full" style="width: {{ $stats['memory_percent'] ?? 0 }}%"></div>
            </div>
        </div>
        <!-- Disk -->
        <div class="flex flex-col gap-3 rounded-xl p-5 border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm">
            <div class="flex justify-between items-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal">Disk Space</p>
                <span class="material-symbols-outlined text-primary">hard_drive</span>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-[#181811] dark:text-white text-3xl font-bold leading-tight">{{ $stats['disk_percent'] ?? 0 }}%</p>
                <p class="text-xs text-gray-400">Used</p>
            </div>
            <div class="w-full bg-background-light dark:bg-[#1f1e0e] rounded-full h-1.5 mt-2">
                <div class="bg-primary h-1.5 rounded-full" style="width: {{ $stats['disk_percent'] ?? 0 }}%"></div>
            </div>
        </div>
        <!-- Uptime -->
        <div class="flex flex-col gap-3 rounded-xl p-5 border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm">
            <div class="flex justify-between items-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal">Uptime</p>
                <span class="material-symbols-outlined text-primary">schedule</span>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-[#181811] dark:text-white text-3xl font-bold leading-tight">
                    {{ \Carbon\Carbon::createFromTimestamp($stats['boot_time'])->diffForHumans(null, true) }}
                </p>
            </div>
            <div class="w-full bg-green-100 dark:bg-green-900/30 rounded-full h-1.5 mt-2 flex items-center">
                <div class="h-1.5 rounded-full w-full bg-green-500"></div>
            </div>
        </div>
    </section>

    <!-- Network & Processes Split -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Network Info Block -->
        <div class="lg:col-span-1 flex flex-col rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm h-full">
            <div class="px-5 py-4 border-b border-border-light dark:border-border-dark flex justify-between items-center">
                <h3 class="text-lg font-bold leading-tight">Network Status</h3>
                <div class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-bold uppercase">Online</div>
            </div>
            <div class="p-5 flex flex-col justify-between flex-1 gap-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <span class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Sent</span>
                        <div class="flex items-center gap-2 text-[#181811] dark:text-white">
                            <span class="material-symbols-outlined text-primary text-xl">arrow_upward</span>
                            <span class="text-xl font-bold">{{ number_format(($stats['net_sent'] ?? 0) / 1024 / 1024, 2) }} MB</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Received</span>
                        <div class="flex items-center gap-2 text-[#181811] dark:text-white">
                            <span class="material-symbols-outlined text-primary text-xl">arrow_downward</span>
                            <span class="text-xl font-bold">{{ number_format(($stats['net_recv'] ?? 0) / 1024 / 1024, 2) }} MB</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="p-3 bg-background-light dark:bg-background-dark rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-gray-400">lan</span>
                            <span class="text-sm font-medium">Local IP</span>
                        </div>
                        <span class="text-sm font-bold font-mono">{{ $stats['local_ip'] ?? 'N/A' }}</span>
                    </div>
                    <div class="p-3 bg-background-light dark:bg-background-dark rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-gray-400">dns</span>
                            <span class="text-sm font-medium">Domain</span>
                        </div>
                        <span class="text-sm font-bold font-mono">{{ env('APP_DOMAIN', $stats['public_ip'] ?? 'N/A') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Processes Table -->
        <div class="lg:col-span-2 flex flex-col rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-border-light dark:border-border-dark">
                <h3 class="text-lg font-bold leading-tight">Top Processes</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-background-light dark:bg-background-dark text-xs uppercase text-gray-500 dark:text-gray-400">
                            <th class="px-5 py-3 font-semibold w-24">PID</th>
                            <th class="px-5 py-3 font-semibold">Process Name</th>
                            <th class="px-5 py-3 font-semibold w-40">CPU %</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-light dark:divide-border-dark">
                        @foreach($stats['processes'] ?? [] as $proc)
                        <tr class="hover:bg-background-light dark:hover:bg-background-dark/50 transition-colors">
                            <td class="px-5 py-3 font-mono text-sm text-gray-600 dark:text-gray-300">{{ $proc['pid'] }}</td>
                            <td class="px-5 py-3 text-sm font-medium text-[#181811] dark:text-white">{{ $proc['name'] }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-full max-w-[80px] h-1.5 rounded-full bg-border-light dark:bg-border-dark overflow-hidden">
                                        <div class="h-full bg-primary" style="width: {{ min($proc['cpu_percent'], 100) }}%;"></div>
                                    </div>
                                    <span class="text-sm font-bold">{{ $proc['cpu_percent'] }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Docker Containers -->
    <section class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <h3 class="text-[#181811] dark:text-white text-xl font-bold leading-tight tracking-[-0.015em]">Docker Containers</h3>
            @if(auth()->user()->isAdmin() || auth()->user()->hasRole('dev'))
            
            @endif
        </div>
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-background-light dark:bg-background-dark text-xs uppercase text-gray-500 dark:text-gray-400">
                            <th class="px-6 py-4 font-semibold w-32">ID</th>
                            <th class="px-6 py-4 font-semibold">Name</th>
                            <th class="px-6 py-4 font-semibold">Image</th>
                            <th class="px-6 py-4 font-semibold w-32">Status</th>
                            <th class="px-6 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-light dark:divide-border-dark">
                        @foreach($containers as $container)
                        <tr class="hover:bg-background-light dark:hover:bg-background-dark/50 transition-colors group">
                            <td class="px-6 py-4 font-mono text-sm text-gray-600 dark:text-gray-300">{{ substr($container['id'], 0, 8) }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-[#181811] dark:text-white">{{ $container['name'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 font-mono">{{ $container['image'] }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold 
                                    {{ ($container['status'] ?? '') == 'running' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                    <span class="size-2 rounded-full {{ ($container['status'] ?? '') == 'running' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ ucfirst($container['status'] ?? 'unknown') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if(auth()->user()->isAdmin() || auth()->user()->hasRole('dev'))
                                <div class="flex items-center justify-end gap-2">
                                    @if(($container['status'] ?? '') == 'running')
                                    <form action="{{ route('docker.action', ['id' => $container['id'], 'action' => 'restart']) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="size-8 rounded-full bg-background-light dark:bg-background-dark hover:bg-border-light dark:hover:bg-border-dark flex items-center justify-center text-gray-600 dark:text-gray-300 transition-colors" title="Restart">
                                            <span class="material-symbols-outlined text-[18px]">replay</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('docker.action', ['id' => $container['id'], 'action' => 'stop']) }}" method="POST" class="inline" onsubmit="return confirm('Stop container?');">
                                        @csrf
                                        <button class="size-8 rounded-full bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 flex items-center justify-center text-red-600 dark:text-red-400 transition-colors" title="Stop">
                                            <span class="material-symbols-outlined text-[18px]">stop</span>
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('docker.action', ['id' => $container['id'], 'action' => 'start']) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="size-8 rounded-full bg-primary hover:bg-yellow-300 flex items-center justify-center text-black transition-colors" title="Start">
                                            <span class="material-symbols-outlined text-[18px]">play_arrow</span>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- App Launcher Grid -->
    <section class="flex flex-col gap-4">
        <h3 class="text-[#181811] dark:text-white text-xl font-bold leading-tight tracking-[-0.015em]">App Launcher</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($apps as $app)
            <a href="{{ route('apps.proxy', ['slug' => $app->slug]) }}" target="_blank" class="group flex flex-col items-center justify-center p-6 rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm hover:shadow-md hover:border-primary transition-all duration-200">
                <div class="size-14 bg-background-light dark:bg-background-dark rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    @if($app->icon)
                    <i class="{{ $app->icon }} text-3xl text-primary"></i>
                    @else
                    <span class="text-2xl font-bold text-gray-500">{{ substr($app->name, 0, 1) }}</span>
                    @endif
                </div>
                <span class="font-bold text-sm text-[#181811] dark:text-white truncate w-full text-center">{{ $app->name }}</span>
            </a>
            @endforeach

            @if(auth()->user()->isAdmin())
            <!-- Add App -->
            <a href="{{ route('admin.apps.create') }}" class="group flex flex-col items-center justify-center p-6 rounded-xl border border-dashed border-border-light dark:border-border-dark bg-transparent hover:bg-surface-light dark:hover:bg-surface-dark/50 transition-all duration-200 cursor-pointer">
                <div class="size-14 rounded-full flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-3xl text-gray-400 group-hover:text-primary transition-colors">add</span>
                </div>
                <span class="font-bold text-sm text-gray-400 group-hover:text-[#181811] dark:group-hover:text-white transition-colors">Add App</span>
            </a>
            @endif
        </div>
    </section>

    <!-- System Controls -->
    @if(auth()->user()->isAdmin())
    <footer class="mt-8 pt-8 border-t border-border-light dark:border-border-dark flex flex-col md:flex-row justify-between items-center gap-4 pb-8">
        <div class="text-sm text-gray-500 dark:text-gray-400 text-center md:text-left">
            <p>System Version: v2.4.1</p>
            <p>Last login: {{ now()->format('M d, H:i') }}</p>
        </div>
        <div class="flex items-center gap-4">
            <!-- Reboot -->
            <button x-data="" x-on:click="$dispatch('open-modal', 'confirm-reboot')" class="bg-primary hover:bg-orange-600 text-white px-6 py-2.5 rounded-full text-sm font-bold flex items-center gap-2 transition-colors shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-[20px]">restart_alt</span>
                Reboot System
            </button>
            <!-- Shutdown -->
            <button x-data="" x-on:click="$dispatch('open-modal', 'confirm-shutdown')" class="bg-[#181811] hover:bg-gray-700 dark:bg-red-500/10 dark:hover:bg-red-500/20 dark:text-red-400 text-white dark:border dark:border-red-500/20 px-6 py-2.5 rounded-full text-sm font-bold flex items-center gap-2 transition-colors">
                <span class="material-symbols-outlined text-[20px]">power_settings_new</span>
                Shutdown
            </button>
        </div>
    </footer>
    @endif

    <!-- MODALS (Hidden) -->
    <!-- Create Container Modal -->
    <x-modal name="create-container" :show="false" focusable>
        <!-- Re-using previous modal logic but wrapped in new design classes if needed, 
             for now keeping the internal form simple/same as before but ensuring it works -->
        <form method="post" action="{{ route('docker.store') }}" class="p-6 bg-surface-light dark:bg-surface-dark text-[#181811] dark:text-white">
            @csrf
            <div class="border-b border-border-light dark:border-border-dark pb-4 mb-4">
                <h2 class="text-xl font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">add_box</span>
                    Create container
                </h2>
                <p class="text-sm text-gray-500 mt-1">Configure and deploy a new Docker instance.</p>
            </div>

            <!-- Name & Image -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1">
                    <x-input-label for="docker_image" value="Image *" class="font-bold uppercase text-xs tracking-wider dark:text-gray-300" />
                    <x-text-input id="docker_image" name="image" type="text" class="mt-1 block w-full bg-background-light dark:bg-background-dark border-border-light dark:border-border-dark focus:ring-primary focus:border-primary" placeholder="e.g. nginx:latest" required />
                </div>
                <div class="col-span-1">
                    <x-input-label for="docker_name" value="Name (Optional)" class="font-bold uppercase text-xs tracking-wider dark:text-gray-300" />
                    <x-text-input id="docker_name" name="name" type="text" class="mt-1 block w-full bg-background-light dark:bg-background-dark border-border-light dark:border-border-dark focus:ring-primary focus:border-primary" placeholder="e.g. my-app-01" />
                </div>
            </div>

            <!-- Network Ports -->
            <div class="mt-6 border border-border-light dark:border-border-dark rounded-lg p-4 bg-background-light dark:bg-background-dark/50">
                <h3 class="text-xs font-bold uppercase mb-3 flex items-center gap-2 dark:text-gray-300">
                    <span class="material-symbols-outlined text-sm">lan</span> Port Mapping
                </h3>
                <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4">
                    <div class="w-full sm:flex-1">
                        <x-text-input id="docker_ports" name="ports" type="text" class="pl-4 block w-full font-mono text-sm border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark focus:ring-primary focus:border-primary" placeholder="8080:80" />
                    </div>
                    <div class="w-full sm:w-auto">
                        <div class="w-full py-2 px-4 bg-border-light dark:bg-border-dark rounded text-sm font-mono text-center font-bold">TCP</div>
                    </div>
                </div>
            </div>

            <!-- Restart Policy -->
            <div class="mt-6">
                <h3 class="text-xs font-bold uppercase mb-3 dark:text-gray-300">Restart Policy</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <label class="cursor-pointer relative">
                        <input type="radio" name="restart" value="no" class="peer sr-only" checked>
                        <div class="rounded-lg border border-border-light dark:border-border-dark p-3 text-center transition-all duration-200 peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary hover:bg-background-light dark:hover:bg-background-dark">
                            <div class="font-bold text-xs">Never</div>
                        </div>
                    </label>
                    <label class="cursor-pointer relative">
                        <input type="radio" name="restart" value="always" class="peer sr-only">
                        <div class="rounded-lg border border-border-light dark:border-border-dark p-3 text-center transition-all duration-200 peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary hover:bg-background-light dark:hover:bg-background-dark">
                            <div class="font-bold text-xs">Always</div>
                        </div>
                    </label>
                    <label class="cursor-pointer relative">
                        <input type="radio" name="restart" value="unless-stopped" class="peer sr-only">
                        <div class="rounded-lg border border-border-light dark:border-border-dark p-3 text-center transition-all duration-200 peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary hover:bg-background-light dark:hover:bg-background-dark">
                            <div class="font-bold text-xs">Unless Stopped</div>
                        </div>
                    </label>
                    <label class="cursor-pointer relative">
                        <input type="radio" name="restart" value="on-failure" class="peer sr-only">
                        <div class="rounded-lg border border-border-light dark:border-border-dark p-3 text-center transition-all duration-200 peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary hover:bg-background-light dark:hover:bg-background-dark">
                            <div class="font-bold text-xs">On Failure</div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 border border-border-light dark:border-border-dark rounded-md text-sm font-bold hover:bg-background-light dark:hover:bg-background-dark">Cancel</button>
                <button class="bg-primary hover:bg-[#e6e205] text-black font-bold py-2 px-6 rounded-md shadow-lg shadow-primary/20 transition-transform hover:-translate-y-0.5">Deploy</button>
            </div>
        </form>
    </x-modal>

    <!-- Reboot Confirm -->
    <x-modal name="confirm-reboot" :show="false" focusable>
        <form method="post" action="{{ route('system.power', 'reboot') }}" class="p-6 bg-surface-light dark:bg-surface-dark text-[#181811] dark:text-white">
            @csrf
            <h2 class="text-lg font-bold">Reboot System?</h2>
            <p class="mt-2 text-sm text-gray-500">Enter password to confirm.</p>
            <div class="mt-4">
                <x-text-input id="password_reboot" name="password" type="password" class="block w-full bg-background-light dark:bg-background-dark border-border-light dark:border-border-dark focus:ring-primary focus:border-primary" placeholder="Password" required />
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 border border-border-light dark:border-border-dark rounded-md text-sm font-bold">Cancel</button>
                <button class="bg-primary hover:bg-[#e6e205] text-black font-bold py-2 px-6 rounded-md">Reboot</button>
            </div>
        </form>
    </x-modal>

    <!-- Shutdown Confirm -->
    <x-modal name="confirm-shutdown" :show="false" focusable>
        <form method="post" action="{{ route('system.power', 'shutdown') }}" class="p-6 bg-surface-light dark:bg-surface-dark text-[#181811] dark:text-white">
            @csrf
            <h2 class="text-lg font-bold text-red-600">SHUTDOWN System?</h2>
            <p class="mt-2 text-sm text-gray-500">Enter password to confirm.</p>
            <div class="mt-4">
                <x-text-input id="password_shutdown" name="password" type="password" class="block w-full bg-background-light dark:bg-background-dark border-border-light dark:border-border-dark focus:ring-primary focus:border-primary" placeholder="Password" required />
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 border border-border-light dark:border-border-dark rounded-md text-sm font-bold">Cancel</button>
                <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-md">Shutdown</button>
            </div>
        </form>
    </x-modal>

</x-app-layout>
