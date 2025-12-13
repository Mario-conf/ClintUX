<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- System Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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