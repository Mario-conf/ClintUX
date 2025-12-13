<x-app-layout>
    <x-admin.header
        title="New Application"
        description="Register a new internal or external application to be displayed on the dashboard."
        :breadcrumbs="['Apps' => route('admin.apps.index'), 'Create' => '#']">
        <x-slot:actions>
            <a href="{{ route('admin.apps.index') }}" class="flex items-center justify-center gap-2 h-9 md:h-10 px-4 md:px-6 rounded-lg border border-border-light dark:border-border-dark text-gray-600 dark:text-gray-300 text-sm font-bold hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                Cancel
            </a>
            <button form="create-app-form" type="submit" class="flex items-center justify-center gap-2 h-9 md:h-10 px-4 md:px-6 rounded-lg bg-primary text-[#181811] text-sm font-bold hover:brightness-105 active:scale-95 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">save</span>
                Save App
            </button>
        </x-slot:actions>
    </x-admin.header>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Form -->
        <div class="flex-1 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm p-6 md:p-8">
            <form id="create-app-form" method="POST" action="{{ route('admin.apps.store') }}" class="flex flex-col gap-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Application Name</label>
                        <input name="name" value="{{ old('name') }}" type="text" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="e.g. Finance Dashboard" required />
                        @error('name') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Role -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Allowed Role</label>
                        <div class="relative">
                            <select name="role_id" class="w-full appearance-none rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                <option value="">All Users</option>
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

                    <!-- URL -->
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Destination URL</label>
                        <div class="flex rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 overflow-hidden focus-within:ring-1 focus-within:ring-primary focus-within:border-primary transition-all">
                            <div class="flex items-center justify-center px-4 bg-gray-100 dark:bg-white/5 border-r border-border-light dark:border-border-dark text-gray-500 text-sm font-mono">
                                url
                            </div>
                            <input name="url" value="{{ old('url') }}" type="url" class="flex-1 border-0 bg-transparent p-2.5 text-sm focus:ring-0 placeholder:text-gray-400" placeholder="http://app.example.com" required />
                        </div>
                        @error('url') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Icon -->
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Icon Class</label>
                        <div class="flex gap-4">
                            <div class="flex items-center justify-center size-11 rounded-lg border border-dashed border-border-light dark:border-border-dark bg-gray-50 dark:bg-white/5 text-gray-400">
                                <span class="material-symbols-outlined">image</span>
                            </div>
                            <div class="flex-1">
                                <input name="icon" value="{{ old('icon') }}" type="text" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="material-symbols-outlined or fa-solid..." />
                                <p class="text-[11px] text-gray-500 mt-1.5">Supports Material Symbols and FontAwesome classes.</p>
                            </div>
                        </div>
                        @error('icon') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Short Description</label>
                        <textarea name="description" rows="3" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none" placeholder="Briefly describe the application...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="w-full lg:w-80 flex flex-col gap-6">
            <div class="rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark p-6 shadow-sm">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-4">Quick Tips</h3>
                <ul class="flex flex-col gap-4">
                    <li class="flex gap-3 text-sm text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0">verified_user</span>
                        <span>Assigning a specific role restricts access. Leave "All Users" for public apps.</span>
                    </li>
                    <li class="flex gap-3 text-sm text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0">dns</span>
                        <span>Use internal Docker IPs (e.g., http://172.18.0.x:port) for faster local routing if configured.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>