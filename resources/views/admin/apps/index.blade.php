<x-admin-layout>
    <!-- Page Header -->
    <header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">Application Management</h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400">Manage launcher applications, access controls, and integrations.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.apps.create') }}" class="flex items-center gap-2 rounded-full bg-primary px-5 py-2.5 text-sm font-bold text-black shadow-lg shadow-primary/20 hover:bg-[#e6e205] transition-all">
                <span class="material-symbols-outlined text-[20px]">add</span>
                New App
            </a>
        </div>
    </header>

    <!-- Search/Filter (Visual Only for now, connected to nothing) -->
    <div class="mb-8 hidden">
        <label class="relative flex w-full max-w-lg items-center">
            <span class="absolute left-4 text-slate-400">
                <span class="material-symbols-outlined">search</span>
            </span>
            <input class="h-12 w-full rounded-full border-0 bg-white pl-12 pr-4 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-gray-200 placeholder:text-slate-400 focus:ring-2 focus:ring-primary dark:bg-card-dark dark:text-white dark:ring-white/10 dark:focus:ring-primary/50 transition-shadow" placeholder="Search applications..." type="text" />
        </label>
    </div>

    @if(session('success'))
    <div class="mb-6 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4 text-green-800 dark:text-green-300 flex items-center gap-3">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    <!-- Table Section -->
    <div class="mb-10 overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-card-dark">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] table-auto">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50 dark:border-gray-800 dark:bg-white/5">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Icon</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Application Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Destination URL</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Allowed Role</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($apps as $app)
                    <tr class="group hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-50 text-slate-600 dark:bg-slate-900/30 dark:text-slate-400">
                                @if($app->icon)
                                <i class="{{ $app->icon }} text-[24px]"></i>
                                @else
                                <span class="font-bold text-lg">{{ substr($app->name, 0, 1) }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 dark:text-white">{{ $app->name }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">{{ Str::limit($app->description, 30) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                <span class="truncate max-w-[200px]">{{ $app->url }}</span>
                                <button onclick="navigator.clipboard.writeText('{{ $app->url }}')" class="text-slate-400 hover:text-primary transition-colors" title="Copy URL">
                                    <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($app->active)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-slate-500 dark:bg-white/10 dark:text-slate-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Inactive
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-slate-600 dark:bg-white/10 dark:text-slate-300">
                                {{ ucfirst($app->role ? $app->role->name : 'All') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.apps.edit', $app->id) }}" class="flex h-8 w-8 items-center justify-center rounded-full text-slate-400 hover:bg-primary hover:text-black transition-all" title="Edit">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                <form action="{{ route('admin.apps.destroy', $app->id) }}" method="POST" onsubmit="return confirm('Delete this app?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="flex h-8 w-8 items-center justify-center rounded-full text-slate-400 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 dark:hover:text-red-400 transition-all" title="Delete">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            No applications found. Click "New App" to add one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if($apps->hasPages())
        <div class="flex items-center justify-between border-t border-gray-100 px-6 py-4 dark:border-gray-800">
            {{ $apps->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>