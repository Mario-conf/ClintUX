<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Applications Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($apps as $app)
                <a href="{{ route('apps.proxy', ['slug' => $app->slug]) }}" target="_blank" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                    <div class="p-4 text-center">
                        <div class="h-12 w-12 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-2 text-2xl">
                            @if($app->icon)
                            <i class="{{ $app->icon }}"></i>
                            @else
                            <span>{{ substr($app->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white truncate">{{ $app->name }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $app->description }}</p>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- System Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Server Info (Admin Only) -->
                @if(auth()->user()->isAdmin())
                <div class="md:col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 flex justify-between items-center text-sm">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-500 dark:text-gray-400 font-bold">Server IPs:</span>
                        <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-800 dark:text-gray-200 font-mono">Local: {{ $stats['local_ip'] ?? 'N/A' }}</span>
                        <span class="bg-blue-100 dark:bg-blue-900 px-2 py-1 rounded text-blue-800 dark:text-blue-200 font-bold">Domain: {{ env('APP_DOMAIN', $stats['public_ip'] ?? 'N/A') }}</span>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        Uptime: {{ \Carbon\Carbon::createFromTimestamp($stats['boot_time'])->diffForHumans(null, true) }}
                    </div>
                </div>
                @endif

                <!-- Power Controls (Admin Only - Moved below info) -->
                @if(auth()->user()->isAdmin())
                <div class="md:col-span-3 flex justify-end space-x-4">
                    <button x-data="" x-on:click="$dispatch('open-modal', 'confirm-reboot')"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow">
                        Reboot System
                    </button>
                    <button x-data="" x-on:click="$dispatch('open-modal', 'confirm-shutdown')"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">
                        Shutdown System
                    </button>

                    <!-- Modals -->
                    <x-modal name="confirm-reboot" :show="false" focusable>
                        <form method="post" action="{{ route('system.power', 'reboot') }}" class="p-6">
                            @csrf
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Are you sure you want to reboot?</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Enter your password to confirm.</p>
                            <div class="mt-6">
                                <x-input-label for="password_reboot" value="Password" class="sr-only" />
                                <x-text-input id="password_reboot" name="password" type="password" class="mt-1 block w-3/4" placeholder="Password" required />
                            </div>
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                                <x-danger-button class="ml-3">Reboot</x-danger-button>
                            </div>
                        </form>
                    </x-modal>

                    <x-modal name="confirm-shutdown" :show="false" focusable>
                        <form method="post" action="{{ route('system.power', 'shutdown') }}" class="p-6">
                            @csrf
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Are you sure you want to SHUTDOWN?</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Enter your password to confirm.</p>
                            <div class="mt-6">
                                <x-input-label for="password_shutdown" value="Password" class="sr-only" />
                                <x-text-input id="password_shutdown" name="password" type="password" class="mt-1 block w-3/4" placeholder="Password" required />
                            </div>
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                                <x-danger-button class="ml-3">Shutdown</x-danger-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
                @endif

                <!-- CPU -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider mb-2">CPU Usage</div>
                    <div class="flex items-end items-baseline">
                        <span class="text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['cpu_percent'] ?? 0 }}</span>
                        <span class="text-xl text-gray-500 dark:text-gray-400 ml-1">%</span>
                    </div>
                </div>

                <!-- Memory -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider mb-2">Memory Usage</div>
                    <div class="flex items-center">
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['memory_percent'] }}%</div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-4">
                        <div class="bg-purple-600 h-2.5 rounded-full" style="width: {{ $stats['memory_percent'] }}%"></div>
                    </div>
                </div>

                <!-- Disk -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider mb-2">Disk Usage</div>
                    <div class="flex items-center">
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['disk_percent'] }}%</div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-4">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $stats['disk_percent'] }}%"></div>
                    </div>
                </div>

                <!-- Network -->
                <div class="md:col-span-3 grid grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider mb-2">Network Sent</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format(($stats['net_sent'] ?? 0) / 1024 / 1024, 2) }} MB</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider mb-2">Network Recv</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format(($stats['net_recv'] ?? 0) / 1024 / 1024, 2) }} MB</div>
                    </div>
                </div>

                <!-- Top Processes -->
                <div class="md:col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Top Processes (by CPU)</h3>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPU %</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MEM %</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($stats['processes'] ?? [] as $proc)
                            <tr>
                                <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $proc['pid'] }}</td>
                                <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $proc['name'] }}</td>
                                <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">{{ $proc['cpu_percent'] }}%</td>
                                <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">{{ number_format($proc['memory_percent'], 1) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Containers List -->

            <!-- Docker Containers Card -->
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold">Docker Containers</h3>
                    @if(auth()->user()->isAdmin() || auth()->user()->hasRole('dev'))
                    <button x-data="" x-on:click="$dispatch('open-modal', 'create-container')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                        + Create Container
                    </button>
                    @endif
                </div>

                <x-modal name="create-container" :show="false" focusable>
                    <form method="post" action="{{ route('docker.store') }}" class="p-6">
                        @csrf
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                </svg>
                                Create container
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configure and deploy a new Docker instance.</p>
                        </div>

                        <!-- Name & Image -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-1">
                                <x-input-label for="docker_image" value="Image *" class="font-bold uppercase text-xs tracking-wider" />
                                <x-text-input id="docker_image" name="image" type="text" class="mt-1 block w-full bg-gray-50 dark:bg-gray-900 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. nginx:latest" required />
                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    DockerHub Registry (default)
                                </p>
                            </div>
                            <div class="col-span-1">
                                <x-input-label for="docker_name" value="Name (Optional)" class="font-bold uppercase text-xs tracking-wider" />
                                <x-text-input id="docker_name" name="name" type="text" class="mt-1 block w-full bg-gray-50 dark:bg-gray-900 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. my-app-01" />
                                <p class="text-xs text-gray-500 mt-1">Random name if empty.</p>
                            </div>
                        </div>

                        <!-- Network Ports -->
                        <div class="mt-6 border dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900/40">
                            <h3 class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                Port Mapping
                            </h3>
                            <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4">
                                <div class="w-full sm:flex-1">
                                    <x-input-label for="docker_ports" value="Host Port:Container Port" class="text-xs mb-1 sr-only" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">🔗</span>
                                        </div>
                                        <x-text-input id="docker_ports" name="ports" type="text" class="pl-8 block w-full font-mono text-sm border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500" placeholder="8080:80" />
                                    </div>
                                </div>
                                <div class="text-gray-400 hidden sm:block">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                    </svg>
                                </div>
                                <div class="w-full sm:w-auto">
                                    <div class="w-full py-2 px-4 bg-gray-200 dark:bg-gray-700 rounded text-sm text-gray-600 dark:text-gray-300 font-mono text-center font-bold">
                                        TCP / UDP
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Restart Policy -->
                        <div class="mt-6">
                            <h3 class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-3">Restart Policy</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="restart" value="no" class="peer sr-only" checked>
                                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-3 text-center transition-all duration-200
                                                peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:text-blue-700 dark:peer-checked:text-blue-300 peer-checked:shadow-sm
                                                hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <div class="font-bold text-xs sm:text-sm">Never</div>
                                    </div>
                                </label>
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="restart" value="always" class="peer sr-only">
                                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-3 text-center transition-all duration-200
                                                peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:text-blue-700 dark:peer-checked:text-blue-300 peer-checked:shadow-sm
                                                hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <div class="font-bold text-xs sm:text-sm">Always</div>
                                    </div>
                                </label>
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="restart" value="unless-stopped" class="peer sr-only">
                                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-3 text-center transition-all duration-200
                                                peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:text-blue-700 dark:peer-checked:text-blue-300 peer-checked:shadow-sm
                                                hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <div class="font-bold text-xs sm:text-sm">Unless Stopped</div>
                                    </div>
                                </label>
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="restart" value="on-failure" class="peer sr-only">
                                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-3 text-center transition-all duration-200
                                                peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:text-blue-700 dark:peer-checked:text-blue-300 peer-checked:shadow-sm
                                                hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <div class="font-bold text-xs sm:text-sm">On Failure</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4 bg-gray-50 dark:bg-gray-900/50 -mx-6 -mb-6 p-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" x-on:click="$dispatch('close')" class="w-full sm:w-auto px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0">
                                Cancel
                            </button>
                            <button class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Deploy container
                            </button>
                        </div>
                    </form>
                </x-modal>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Image</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Controls</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($containers as $container)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono">
                                        {{ $container['id'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $container['name'] ?? 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $container['image'] ?? 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ ($container['status'] ?? '') == 'running' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            {{ $container['status'] ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if(auth()->user()->isAdmin() || auth()->user()->hasRole('dev'))
                                        <div class="flex justify-end space-x-2">
                                            @if(($container['status'] ?? '') == 'running')
                                            <form action="{{ route('docker.action', ['id' => $container['id'], 'action' => 'restart']) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-orange-500 hover:text-orange-900" title="Restart">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('docker.action', ['id' => $container['id'], 'action' => 'stop']) }}" method="POST" class="inline" onsubmit="return confirm('Stop container?');">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Stop">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ route('docker.action', ['id' => $container['id'], 'action' => 'start']) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900" title="Start">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                                    </svg>
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
            </div>

        </div>
    </div>
</x-app-layout>