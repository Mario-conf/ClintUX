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
                <!-- Power Controls (Admin Only) -->
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

                <!-- RAM -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider mb-2">Memory</div>
                    <div class="flex items-end items-baseline">
                        <span class="text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['memory_percent'] ?? 0 }}</span>
                        <span class="text-xl text-gray-500 dark:text-gray-400 ml-1">%</span>
                    </div>
                </div>

                <!-- Disk -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider mb-2">Disk</div>
                    <div class="flex items-end items-baseline">
                        <span class="text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['disk_percent'] ?? 0 }}</span>
                        <span class="text-xl text-gray-500 dark:text-gray-400 ml-1">%</span>
                    </div>
                </div>
            </div>

            <!-- Containers List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Details</h3>
                        <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded dark:bg-indigo-900 dark:text-indigo-300">
                            Python Backend Connected
                        </span>
                    </div>

                    @if(empty($containers))
                    <p class="text-gray-500 dark:text-gray-400 italic">No containers found or Docker is not running.</p>
                    @else
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
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>