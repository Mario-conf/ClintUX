<x-admin-layout>
    <!-- Header Sticky -->
    <header class="w-full flex flex-col gap-6 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md sticky top-0 z-10 mb-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Home</a>
                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                    <span>Admin</span>
                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                    <span class="text-black dark:text-white font-medium">Logs</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-black tracking-tight text-[#181811] dark:text-white">Audit Logs</h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-lg">View and manage comprehensive system activity history for security and compliance.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="flex items-center justify-center gap-2 h-10 px-6 rounded-full bg-primary text-[#181811] text-sm font-bold hover:brightness-105 active:scale-95 transition-all shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-[20px]">download</span>
                    <span>Export CSV</span>
                </button>
            </div>
        </div>

        <!-- KPI Stats Row (Mock Data for Visuals, could be dynamic later) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="flex flex-col gap-1 p-5 rounded-2xl bg-white dark:bg-surface-dark border border-border-light dark:border-border-dark shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Events</p>
                    <span class="material-symbols-outlined text-gray-400">history</span>
                </div>
                <div class="flex items-end gap-2 mt-2">
                    <p class="text-2xl font-bold tracking-tight">{{ $audits->total() }}</p>
                    <p class="text-emerald-600 text-sm font-bold mb-1 flex items-center">
                        <span class="material-symbols-outlined text-[16px]">arrow_upward</span> 12%
                    </p>
                </div>
            </div>
            <div class="flex flex-col gap-1 p-5 rounded-2xl bg-white dark:bg-surface-dark border border-border-light dark:border-border-dark shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Recent Activity</p>
                    <span class="material-symbols-outlined text-gray-400">schedule</span>
                </div>
                <div class="flex items-end gap-2 mt-2">
                    <p class="text-2xl font-bold tracking-tight">{{ $audits->count() }}</p>
                    <p class="text-gray-400 text-sm font-medium mb-1">Items on page</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Search & Filters Toolbar -->
    <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center bg-white dark:bg-surface-dark p-2 rounded-[24px] border border-border-light dark:border-border-dark shadow-sm mb-6">
        <!-- Search -->
        <div class="relative w-full lg:w-96 group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors">search</span>
            </div>
            <input class="block w-full pl-12 pr-4 py-3 bg-background-light dark:bg-background-dark border-none rounded-full text-sm font-medium placeholder-gray-500 focus:ring-2 focus:ring-primary focus:bg-white dark:focus:bg-[#363520] transition-all" placeholder="Search by keyword, user, or IP..." type="text" />
        </div>
        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-2 px-2 pb-2 lg:pb-0">
            <button class="flex items-center gap-2 px-4 py-2 rounded-full bg-background-light dark:bg-background-dark hover:bg-white dark:hover:bg-[#363520] border border-transparent hover:border-border-light dark:border-border-dark transition-all text-sm font-medium">
                <span>Action: All Types</span>
                <span class="material-symbols-outlined text-[18px]">expand_more</span>
            </button>
            <div class="w-px h-6 bg-gray-300 dark:bg-gray-700 mx-2 hidden sm:block"></div>
            <button class="flex items-center gap-2 px-4 py-2 rounded-full text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all text-sm font-bold">
                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                <span>Reset</span>
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-3xl overflow-hidden shadow-sm flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-background-light dark:bg-background-dark border-b border-border-light dark:border-border-dark">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                            User Account
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                            Action
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">IP Address</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                            Timestamp
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap text-right">Context</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @forelse($audits as $audit)
                    <tr class="hover:bg-background-light dark:hover:bg-background-dark/50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark flex items-center justify-center font-bold text-primary">
                                    {{ substr($audit->user->name ?? 'System', 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-sm text-[#181811] dark:text-gray-100">{{ $audit->user->name ?? 'System' }}</span>
                                    <span class="text-xs text-gray-500">{{ $audit->user->email ?? 'automated@system' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                            $eventColor = match($audit->event) {
                            'created' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200',
                            'updated' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200',
                            'deleted' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300 border border-rose-200',
                            'login' => 'bg-primary/20 text-black dark:text-white border border-primary/40',
                            'login_failed' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300 border border-orange-200',
                            default => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300 border border-gray-200'
                            };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $eventColor }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-75"></span>
                                {{ ucfirst(str_replace('_', ' ', $audit->event)) }}
                            </span>
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
        <!-- Pagination -->
        @if($audits->hasPages())
        <div class="p-4 border-t border-border-light dark:border-border-dark bg-background-light/50 dark:bg-background-dark/30">
            {{ $audits->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>