<x-app-layout>
    <x-admin.header
        title="New User"
        description="Create a new user account and assign roles."
        :breadcrumbs="['Users' => route('admin.users.index'), 'Create' => '#']">
        <x-slot:actions>
            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-center gap-2 h-9 md:h-10 px-4 md:px-6 rounded-lg border border-border-light dark:border-border-dark text-gray-600 dark:text-gray-300 text-sm font-bold hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                Cancel
            </a>
            <button form="create-user-form" type="submit" class="flex items-center justify-center gap-2 h-9 md:h-10 px-4 md:px-6 rounded-lg bg-primary text-[#181811] text-sm font-bold hover:brightness-105 active:scale-95 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">save</span>
                Create User
            </button>
        </x-slot:actions>
    </x-admin.header>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Form -->
        <div class="flex-1 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm p-6 md:p-8">
            <form id="create-user-form" method="POST" action="{{ route('admin.users.store') }}" class="flex flex-col gap-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Full Name</label>
                        <input name="name" value="{{ old('name') }}" type="text" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="e.g. John Doe" required />
                        @error('name') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Email Address</label>
                        <input name="email" value="{{ old('email') }}" type="email" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="john@company.com" required />
                        @error('email') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Password</label>
                        <input name="password" type="password" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required />
                        @error('password') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Confirm Password</label>
                        <input name="password_confirmation" type="password" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required />
                    </div>

                    <!-- Role -->
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Role</label>
                        <div class="relative">
                            <select name="role_id" class="w-full appearance-none rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <span class="material-symbols-outlined">expand_more</span>
                            </div>
                        </div>
                        @error('role_id') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="w-full lg:w-80 flex flex-col gap-6">
            <div class="rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark p-6 shadow-sm">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-4">Security Tips</h3>
                <ul class="flex flex-col gap-4">
                    <li class="flex gap-3 text-sm text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0">lock</span>
                        <span>Use strong passwords (min 8 chars, mixed case, symbols).</span>
                    </li>
                    <li class="flex gap-3 text-sm text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0">admin_panel_settings</span>
                        <span>Admin role grants full system access. Grant sparingly.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>