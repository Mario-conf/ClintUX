<x-app-layout>
    <x-admin.header
        title="Audit Logs"
        description="View and manage comprehensive system activity history for security and compliance."
        :breadcrumbs="['Logs' => '#']">
        <x-slot:actions>
            <button class="flex items-center justify-center gap-2 h-9 md:h-10 px-4 md:px-6 rounded-lg bg-primary text-[#181811] text-sm font-bold hover:brightness-105 active:scale-95 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">download</span>
                <span class="hidden sm:inline">Export CSV</span>
                <span class="sm:hidden">Export</span>
            </button>
        </x-slot:actions>

        <x-slot:stats>
            <div class="flex flex-col gap-1 p-4 md:p-5 rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm font-medium">Total Events</p>
                    <span class="material-symbols-outlined text-gray-400 text-lg md:text-xl">history</span>
                </div>
                <div class="flex items-end gap-2 mt-2">
                    <p class="text-xl md:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $audits->total() }}</p>
                </div>
            </div>
            <div class="flex flex-col gap-1 p-4 md:p-5 rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm font-medium">System Health</p>
                    <span class="material-symbols-outlined text-gray-400 text-lg md:text-xl">monitor_heart</span>
                </div>
                <div class="flex items-end gap-2 mt-2">
                    <p class="text-xl md:text-2xl font-bold tracking-tight text-primary">100%</p>
                    <p class="text-gray-400 text-xs font-medium mb-1">Uptime</p>
                </div>
            </div>
        </x-slot:stats>
    </x-admin.header>

    <!-- Data Display -->
    <div class="bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl overflow-hidden shadow-sm flex flex-col">
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-border-light dark:border-border-dark">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">User</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Action</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">IP Address</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Timestamp</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap text-right">Context</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @forelse($audits as $audit)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="bg-center bg-no-repeat bg-cover rounded-full size-8 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark flex items-center justify-center font-bold text-xs text-primary shrink-0">
                                    {{ substr($audit->user->name ?? 'S', 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-sm text-[#181811] dark:text-gray-100">{{ $audit->user->name ?? 'System' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                            $eventColor = match($audit->event) {
                            'created' => 'success',
                            'updated' => 'info',
                            'deleted' => 'error',
                            'login' => 'primary',
                            'login_failed' => 'orange',
                            default => 'neutral'
                            };
                            @endphp
                            <x-ui.badge :color="$eventColor" :label="ucfirst(str_replace('_', ' ', $audit->event))" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-mono text-sm text-gray-600 dark:text-gray-400">{{ $audit->ip_address }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium">{{ $audit->created_at->format('M d, Y') }}</span>
                                <span class="text-xs text-gray-500">{{ $audit->created_at->format('H:i:s') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                            {{ Str::limit($audit->description, 30) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">No logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Stacked List -->
        <div class="md:hidden flex flex-col divide-y divide-border-light dark:divide-border-dark">
            @forelse($audits as $audit)
            <div class="p-4 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        @php
                        $eventColor = match($audit->event) {
                        'created' => 'success',
                        'updated' => 'info',
                        'deleted' => 'error',
                        'login' => 'primary',
                        'login_failed' => 'orange',
                        default => 'neutral'
                        };
                        @endphp
                        <x-ui.badge :color="$eventColor" :label="ucfirst(str_replace('_', ' ', $audit->event))" />
                        <span class="text-xs text-gray-500">{{ $audit->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2 text-sm font-bold text-slate-900 dark:text-white">
                        <span>{{ $audit->user->name ?? 'System' }}</span>
                        <span class="text-gray-400 font-normal">from</span>
                        <span class="font-mono text-xs">{{ $audit->ip_address }}</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $audit->description }}</p>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">No logs found.</div>
            @endforelse
        </div>

        @if($audits->hasPages())
        <div class="p-4 border-t border-border-light dark:border-border-dark bg-background-light/50 dark:bg-background-dark/30">
            {{ $audits->links() }}
        </div>
        @endif
    </div>
</x-app-layout>