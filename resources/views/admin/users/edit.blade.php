<x-app-layout>
    <x-admin.header 
        title="Edit User" 
        :description="'Update profile for ' . $user->name"
        :breadcrumbs="['Users' => route('admin.users.index'), 'Edit' => '#']"
    >
        <x-slot:actions>
             <a href="{{ route('admin.users.index') }}" class="flex items-center justify-center gap-2 h-9 md:h-10 px-4 md:px-6 rounded-lg border border-border-light dark:border-border-dark text-gray-600 dark:text-gray-300 text-sm font-bold hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                Cancel
            </a>
            <button form="edit-user-form" type="submit" class="flex items-center justify-center gap-2 h-9 md:h-10 px-4 md:px-6 rounded-lg bg-primary text-[#181811] text-sm font-bold hover:brightness-105 active:scale-95 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">save</span>
                Update User
            </button>
        </x-slot:actions>
    </x-admin.header>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Form -->
        <div class="flex-1 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm p-6 md:p-8">
            <form id="edit-user-form" method="POST" action="{{ route('admin.users.update', $user->id) }}" class="flex flex-col gap-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Full Name</label>
                        <input name="name" value="{{ old('name', $user->name) }}" type="text" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required />
                        @error('name') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Email Address</label>
                        <input name="email" value="{{ old('email', $user->email) }}" type="email" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required />
                        @error('email') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                     <!-- Role -->
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Role</label>
                         <div class="relative">
                            <select name="role_id" class="w-full appearance-none rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                             <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <span class="material-symbols-outlined">expand_more</span>
                            </div>
                        </div>
                        @error('role_id') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password Update (Optional) -->
                    <div class="md:col-span-2 border-t border-border-light dark:border-border-dark pt-6 mt-2">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Change Password</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-bold text-gray-500 dark:text-gray-400">New Password</label>
                                <input name="password" type="password" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" />
                                @error('password') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-bold text-gray-500 dark:text-gray-400">Confirm New Password</label>
                                <input name="password_confirmation" type="password" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" />
                            </div>
                        </div>
                    </div>

                     <!-- Active Toggle -->
                    <div class="flex items-center gap-3 md:col-span-2 mt-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="active" value="1" class="sr-only peer" {{ $user->active ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/50 dark:peer-focus:ring-primary/30 rounded-full peer dark:bg-white/10 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            <span class="ml-3 text-sm font-bold text-slate-900 dark:text-white">Active Account</span>
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="w-full lg:w-80 flex flex-col gap-6">
            <div class="rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark p-6 shadow-sm">
                 <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-4">User Details</h3>
                 <ul class="flex flex-col gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex justify-between">
                        <span>Joined</span>
                        <span class="font-mono">{{ $user->created_at->format('M d, Y') }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Last Updated</span>
                        <span class="font-mono">{{ $user->updated_at->diffForHumans() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>