<x-app-layout>
    <x-admin.header
        title="Edit Application"
        :description="'Update configuration for ' . $app->name"
        :breadcrumbs="['Apps' => route('admin.apps.index'), 'Edit' => '#']">
        <x-slot:actions>
            <a href="{{ route('admin.apps.index') }}" class="flex items-center justify-center gap-2 h-9 md:h-10 px-4 md:px-6 rounded-lg border border-border-light dark:border-border-dark text-gray-600 dark:text-gray-300 text-sm font-bold hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                Cancel
            </a>
            <button form="edit-app-form" type="submit" class="flex items-center justify-center gap-2 h-9 md:h-10 px-4 md:px-6 rounded-lg bg-primary text-[#181811] text-sm font-bold hover:brightness-105 active:scale-95 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">save</span>
                Update App
            </button>
        </x-slot:actions>
    </x-admin.header>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Form -->
        <div class="flex-1 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm p-6 md:p-8">
            <form id="edit-app-form" method="POST" action="{{ route('admin.apps.update', $app->id) }}" class="flex flex-col gap-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Application Name</label>
                        <input name="name" value="{{ old('name', $app->name) }}" type="text" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required />
                        @error('name') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Role -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Allowed Role</label>
                        <div class="relative">
                            <select name="role_id" class="w-full appearance-none rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                <option value="">All Users</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $app->role_id) == $role->id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
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
                            <input name="url" value="{{ old('url', $app->url) }}" type="url" class="flex-1 border-0 bg-transparent p-2.5 text-sm focus:ring-0 placeholder:text-gray-400" required />
                        </div>
                        @error('url') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Icon -->
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Icon Class</label>
                        <div class="flex gap-4">
                            <div class="flex items-center justify-center size-11 rounded-lg border border-dashed border-border-light dark:border-border-dark bg-gray-50 dark:bg-white/5 text-gray-400">
                                <span class="material-symbols-outlined">{{ old('icon', $app->icon) ?? 'image' }}</span>
                            </div>
                            <div class="flex-1">
                                <input name="icon" value="{{ old('icon', $app->icon) }}" type="text" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" />
                            </div>
                        </div>
                        @error('icon') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-900 dark:text-white">Short Description</label>
                        <textarea name="description" rows="3" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-gray-50 dark:bg-black/20 p-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none">{{ old('description', $app->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Active Toggle -->
                    <div class="flex items-center gap-3 md:col-span-2 mt-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="active" value="1" class="sr-only peer" {{ $app->active ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/50 dark:peer-focus:ring-primary/30 rounded-full peer dark:bg-white/10 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            <span class="ml-3 text-sm font-bold text-slate-900 dark:text-white">Active Status</span>
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="w-full lg:w-80 flex flex-col gap-6">
            <div class="rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark p-6 shadow-sm">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-4">Application Info</h3>
                <ul class="flex flex-col gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex justify-between">
                        <span>Created</span>
                        <span class="font-mono">{{ $app->created_at->format('M d, Y') }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Updated</span>
                        <span class="font-mono">{{ $app->updated_at->diffForHumans() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>