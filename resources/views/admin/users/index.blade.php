<x-admin-layout>
    <!-- Breadcrumbs -->
    <div class="flex flex-wrap gap-2 text-sm mb-6">
        <a class="text-[#8c8b5f] hover:text-[#181811] dark:hover:text-white font-medium transition-colors" href="{{ route('dashboard') }}">Home</a>
        <span class="text-[#8c8b5f] font-medium">/</span>
        <a class="text-[#8c8b5f] hover:text-[#181811] dark:hover:text-white font-medium transition-colors" href="#">Admin</a>
        <span class="text-[#8c8b5f] font-medium">/</span>
        <span class="text-[#181811] dark:text-white font-semibold">Users</span>
    </div>

    <!-- Page Heading & Actions -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
        <div class="flex flex-col gap-2 max-w-2xl">
            <h2 class="text-[#181811] dark:text-white text-4xl font-black leading-tight tracking-tight">User Management</h2>
            <p class="text-[#8c8b5f] text-base font-normal">Manage team members, roles, account statuses, and permissions across the platform.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="flex shrink-0 cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-6 bg-primary hover:bg-[#e6e205] transition-colors text-[#181811] gap-2 shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined text-[20px] font-bold">add</span>
            <span class="text-sm font-bold tracking-wide">New User</span>
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white dark:bg-surface-dark p-2 rounded-full shadow-sm border border-[#e6e6e1] dark:border-border-dark flex flex-col sm:flex-row gap-2 mb-8">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-[#8c8b5f]">search</span>
            </div>
            <input class="block w-full h-12 pl-12 pr-4 rounded-full bg-transparent text-[#181811] dark:text-white placeholder-[#8c8b5f] focus:outline-none focus:ring-2 focus:ring-primary/50 border-none" placeholder="Search users by name, email, or role..." type="text" />
        </div>
        <div class="flex gap-2">
            <button class="h-12 px-6 rounded-full bg-[#f5f5f0] dark:bg-background-dark text-[#181811] dark:text-[#f5f5f0] font-medium text-sm hover:bg-[#e6e6e1] dark:hover:bg-[#3e3d2b] transition-colors flex items-center gap-2 border border-transparent">
                <span class="material-symbols-outlined text-[20px]">filter_list</span>
                Filter
            </button>
            <button class="h-12 px-6 rounded-full bg-[#f5f5f0] dark:bg-background-dark text-[#181811] dark:text-[#f5f5f0] font-medium text-sm hover:bg-[#e6e6e1] dark:hover:bg-[#3e3d2b] transition-colors flex items-center gap-2 border border-transparent">
                <span class="material-symbols-outlined text-[20px]">download</span>
                Export
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4 text-green-800 dark:text-green-300 flex items-center gap-3">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white dark:bg-surface-dark rounded-3xl border border-[#e6e6e1] dark:border-border-dark overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f8f8f5] dark:bg-background-dark border-b border-[#e6e6e1] dark:border-border-dark">
                        <th class="p-5 pl-8 text-xs font-bold text-[#8c8b5f] uppercase tracking-wider">User</th>
                        <th class="p-5 text-xs font-bold text-[#8c8b5f] uppercase tracking-wider">Role</th>
                        <th class="p-5 text-xs font-bold text-[#8c8b5f] uppercase tracking-wider">Status</th>
                        <th class="p-5 text-xs font-bold text-[#8c8b5f] uppercase tracking-wider">Created</th>
                        <th class="p-5 pr-8 text-xs font-bold text-[#8c8b5f] uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e6e6e1] dark:divide-border-dark">
                    @forelse($users as $user)
                    <tr class="group hover:bg-[#fcfcfb] dark:hover:bg-background-dark/50 transition-colors">
                        <td class="p-5 pl-8">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="size-10 rounded-full bg-background-light dark:bg-background-dark border border-[#e6e6e1] dark:border-border-dark flex items-center justify-center font-bold text-lg text-primary">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    @if($user->active)
                                    <span class="absolute bottom-0 right-0 size-3 rounded-full bg-green-500 border-2 border-white dark:border-[#1a190b]"></span>
                                    @else
                                    <span class="absolute bottom-0 right-0 size-3 rounded-full bg-gray-400 border-2 border-white dark:border-[#1a190b]"></span>
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-[#181811] dark:text-white">{{ $user->name }}</span>
                                    <span class="text-sm text-[#8c8b5f]">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-5">
                            @php
                            $roleColor = match($user->role->slug ?? '') {
                            'admin' => 'bg-primary text-[#181811]',
                            'dev' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                            default => 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300'
                            };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $roleColor }}">
                                {{ strtoupper($user->role->name ?? 'USER') }}
                            </span>
                        </td>
                        <td class="p-5">
                            @if($user->active)
                            <div class="flex items-center gap-2">
                                <div class="size-2 rounded-full bg-green-500"></div>
                                <span class="text-sm font-medium text-[#181811] dark:text-white">Active</span>
                            </div>
                            @else
                            <div class="flex items-center gap-2">
                                <div class="size-2 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                                <span class="text-sm font-medium text-[#8c8b5f]">Inactive</span>
                            </div>
                            @endif
                        </td>
                        <td class="p-5">
                            <span class="text-sm text-[#8c8b5f] font-medium">{{ $user->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="p-5 pr-8 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="size-8 flex items-center justify-center rounded-full bg-[#f5f5f0] dark:bg-background-dark hover:bg-[#e6e6e1] dark:hover:bg-[#3e3d2b] text-[#181811] dark:text-white transition-colors" title="Edit User">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete user?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="size-8 flex items-center justify-center rounded-full bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 transition-colors" title="Delete User">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-[#8c8b5f]">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-8 py-5 border-t border-[#e6e6e1] dark:border-border-dark bg-[#f8f8f5] dark:bg-background-dark">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>