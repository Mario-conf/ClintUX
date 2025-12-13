<x-admin-layout>
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Form Area -->
        <div class="relative overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-lg dark:border-gray-800 dark:bg-card-dark flex-1">
            <!-- Decorator Strip -->
            <div class="absolute left-0 top-0 h-1 w-full bg-gradient-to-r from-primary to-yellow-200"></div>

            <div class="p-8">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Edit Application</h2>
                    <a href="{{ route('admin.apps.index') }}" class="rounded-full p-2 text-slate-400 hover:bg-gray-100 hover:text-slate-600 dark:hover:bg-white/10">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.apps.update', $app->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- App Name -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Application Name</label>
                            <input name="name" value="{{ old('name', $app->name) }}" type="text" class="w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary dark:border-gray-700 dark:bg-input-dark dark:text-white dark:focus:border-primary" required />
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Role -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Allowed Role</label>
                            <div class="relative">
                                <select name="role_id" class="w-full appearance-none rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm font-medium text-slate-900 focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary dark:border-gray-700 dark:bg-input-dark dark:text-white dark:focus:border-primary">
                                    <option value="">All Users</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $app->role_id) == $role->id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                                    <span class="material-symbols-outlined">expand_more</span>
                                </div>
                            </div>
                            @error('role_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- URL -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Destination URL</label>
                            <div class="flex rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-input-dark">
                                <span class="flex select-none items-center pl-3 text-slate-400">URL</span>
                                <input name="url" value="{{ old('url', $app->url) }}" type="url" class="flex-1 border-0 bg-transparent p-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:ring-0 dark:text-white" required />
                            </div>
                            @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Icon -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Icon Class</label>
                            <div class="flex gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg border border-dashed border-gray-300 bg-white text-slate-300 dark:border-gray-600 dark:bg-white/5">
                                    @if($app->icon)
                                    <i class="{{ $app->icon }}"></i>
                                    @else
                                    <span class="material-symbols-outlined">image</span>
                                    @endif
                                </div>
                                <input name="icon" value="{{ old('icon', $app->icon) }}" type="text" class="flex-1 rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary dark:border-gray-700 dark:bg-input-dark dark:text-white dark:focus:border-primary" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Short Description</label>
                            <textarea name="description" class="w-full resize-none rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary dark:border-gray-700 dark:bg-input-dark dark:text-white dark:focus:border-primary" rows="3">{{ old('description', $app->description) }}</textarea>
                        </div>

                        <!-- Active Switch -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="flex items-center gap-3 cursor-pointer group select-none">
                                <div class="relative flex items-center justify-center w-5 h-5">
                                    <input type="hidden" name="active" value="0">
                                    <input name="active" type="checkbox" value="1" {{ old('active', $app->active) ? 'checked' : '' }} class="peer appearance-none w-5 h-5 border-2 border-[#e6e6db] dark:border-[#6f6e4d] rounded bg-transparent checked:bg-primary checked:border-primary transition-all cursor-pointer" />
                                    <span class="material-symbols-outlined absolute text-black text-sm opacity-0 peer-checked:opacity-100 font-bold pointer-events-none transform scale-75 transition-transform">check</span>
                                </div>
                                <span class="text-sm font-medium text-[#8c8b5f] dark:text-[#cac99d] group-hover:text-[#181811] dark:group-hover:text-white transition-colors">Active</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">
                        <a href="{{ route('admin.apps.index') }}" class="rounded-full px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-gray-100 dark:text-slate-300 dark:hover:bg-white/10 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="rounded-full bg-primary px-6 py-2.5 text-sm font-bold text-black shadow-lg shadow-primary/20 hover:bg-[#e6e205] transition-all">
                            Update App
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>