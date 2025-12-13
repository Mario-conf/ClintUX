<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Audit Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($audits as $audit)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $audit->user->name ?? 'System/Unknown' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-indigo-600 dark:text-indigo-400">{{ $audit->action }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $audit->target }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $audit->ip_address }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $audits->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>