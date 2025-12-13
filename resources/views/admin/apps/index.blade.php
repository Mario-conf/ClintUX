<x-app-layout>
    <x-admin.header
        title="Application Management"
        description="Manage your registered applications, configure proxies, and control access settings."
        :breadcrumbs="['Apps' => '#']">
        <x-slot:actions>
            <a href="{{ route('admin.apps.create') }}" class="flex items-center justify-center gap-2 h-9 md:h-10 px-4 md:px-6 rounded-lg bg-primary text-[#181811] text-sm font-bold hover:brightness-105 active:scale-95 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span class="hidden sm:inline">New App</span>
                <span class="sm:hidden">New</span>
            </a>
        </x-slot:actions>
    </x-admin.header>

    @if(session('success'))
    <div class="mb-6 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 p-4 text-emerald-800 dark:text-emerald-300 flex items-center gap-3 text-sm font-medium">
        <span class="material-symbols-outlined text-lg">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    <!-- Data Display: Responsive -->
    <div class="bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm flex flex-col">
        <!-- Desktop Table (Hidden on small screens) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-border-light dark:border-border-dark">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Application</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">URL Destination</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Access Scope</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @forelse($apps as $app)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center size-10 rounded-lg bg-primary/10 text-primary-dark border border-primary/20 shrink-0">
                                    <span class="material-symbols-outlined">{{ $app->icon ?? 'apps' }}</span>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="font-bold text-sm text-slate-900 dark:text-white truncate">{{ $app->name }}</span>
                                    <span class="text-xs text-slate-500 truncate max-w-[200px]">{{ $app->description }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ $app->url }}" target="_blank" class="font-mono text-xs md:text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                                {{ Str::limit($app->url, 30) }}
                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <x-ui.badge
                                :color="$app->role->slug === 'admin' ? 'primary' : 'info'"
                                :label="ucfirst($app->role->name)" />
                        </td>
                        <td class="px-6 py-4">
                            <x-ui.badge
                                :color="$app->active ? 'success' : 'neutral'"
                                :label="$app->active ? 'Active' : 'Inactive'" />
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.apps.edit', $app->id) }}" class="size-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10 hover:bg-primary/20 hover:text-primary-dark transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                <form action="{{ route('admin.apps.destroy', $app->id) }}" method="POST" onsubmit="return confirm('Delete app?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="size-8 flex items-center justify-center rounded-lg bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 text-rose-600 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">No applications found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Stacked List (Visible on small screens) -->
        <div class="md:hidden flex flex-col divide-y divide-border-light dark:divide-border-dark">
            @forelse($apps as $app)
            <div class="p-4 flex flex-col gap-3">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center size-10 rounded-lg bg-primary/10 text-primary-dark border border-primary/20 shrink-0">
                            <span class="material-symbols-outlined">{{ $app->icon ?? 'apps' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-sm text-slate-900 dark:text-white">{{ $app->name }}</span>
                            <span class="text-xs text-slate-500">{{ Str::limit($app->description, 50) }}</span>
                        </div>
                    </div>
                    <div class="flex gap-1">
                        <a href="{{ route('admin.apps.edit', $app->id) }}" class="p-2 text-gray-500 hover:text-primary">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                    </div>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <a href="{{ $app->url }}" target="_blank" class="font-mono text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                        {{ Str::limit($app->url, 25) }}
                        <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                    </a>
                    <div class="flex gap-2">
                        <x-ui.badge :color="$app->role->slug === 'admin' ? 'primary' : 'info'" :label="ucfirst($app->role->name)" />
                        <x-ui.badge :color="$app->active ? 'success' : 'neutral'" :label="$app->active ? 'Active' : 'Inactive'" />
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">No apps found.</div>
            @endforelse
        </div>

        @if($apps->hasPages())
        <div class="p-4 border-t border-border-light dark:border-border-dark bg-gray-50 dark:bg-white/5">
            {{ $apps->links() }}
        </div>
        @endif
    </div>
</x-app-layout>