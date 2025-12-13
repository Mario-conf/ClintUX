<x-app-layout>
    <x-admin.header
        title="User Management"
        description="Manage team members, roles, account statuses, and permissions across the platform."
        :breadcrumbs="['Users' => '#']">
        <x-slot:actions>
            <a href="{{ route('admin.users.create') }}" class="flex items-center justify-center gap-2 h-9 md:h-10 px-4 md:px-6 rounded-lg bg-primary text-[#181811] text-sm font-bold hover:brightness-105 active:scale-95 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span class="hidden sm:inline">New User</span>
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

    <!-- Data Display -->
    <div class="bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm flex flex-col">
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-border-light dark:border-border-dark">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="relative shrink-0">
                                    <div class="size-10 rounded-full bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark flex items-center justify-center font-bold text-sm text-primary">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="absolute bottom-0 right-0 size-2.5 rounded-full {{ $user->active ? 'bg-emerald-500' : 'bg-gray-400' }} border-2 border-white dark:border-background-dark"></span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $user->name }}</span>
                                    <span class="text-xs text-slate-500">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                            $color = match($user->role->slug ?? '') {
                            'admin' => 'primary',
                            'dev' => 'info',
                            default => 'neutral'
                            };
                            @endphp
                            <x-ui.badge :color="$color" :label="strtoupper($user->role->name ?? 'USER')" />
                        </td>
                        <td class="px-6 py-4">
                            <x-ui.badge
                                :color="$user->active ? 'success' : 'neutral'"
                                :label="$user->active ? 'Active' : 'Inactive'" />
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-500 font-medium">{{ $user->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="size-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10 hover:bg-primary/20 hover:text-primary-dark transition-colors" title="Edit User">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete user?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="size-8 flex items-center justify-center rounded-lg bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 text-rose-600 transition-colors" title="Delete User">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Stacked List -->
        <div class="md:hidden flex flex-col divide-y divide-border-light dark:divide-border-dark">
            @forelse($users as $user)
            <div class="p-4 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="relative shrink-0">
                            <div class="size-10 rounded-full bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark flex items-center justify-center font-bold text-sm text-primary">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="absolute bottom-0 right-0 size-2.5 rounded-full {{ $user->active ? 'bg-emerald-500' : 'bg-gray-400' }} border-2 border-white dark:border-background-dark"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $user->name }}</span>
                            <span class="text-xs text-slate-500">{{ $user->email }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 text-gray-500 hover:text-primary">
                        <span class="material-symbols-outlined text-[20px]">edit</span>
                    </a>
                </div>
                <div class="flex items-center justify-between pl-[52px]">
                    <div class="flex gap-2">
                        @php
                        $roleColor = match($user->role->slug ?? '') {
                        'admin' => 'primary',
                        'dev' => 'info',
                        default => 'neutral'
                        };
                        @endphp
                        <x-ui.badge :color="$roleColor" :label="strtoupper($user->role->name ?? 'USER')" />
                        <x-ui.badge :color="$user->active ? 'success' : 'neutral'" :label="$user->active ? 'Active' : 'Inactive'" />
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">No users found.</div>
            @endforelse
        </div>

        @if($users->hasPages())
        <div class="px-4 py-3 border-t border-border-light dark:border-border-dark bg-gray-50 dark:bg-white/5">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</x-app-layout>