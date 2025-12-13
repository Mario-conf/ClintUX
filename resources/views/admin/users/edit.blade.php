<x-admin-layout>
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Form Area -->
        <div class="relative overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-lg dark:border-gray-800 dark:bg-card-dark flex-1">
            <!-- Decorator Strip -->
            <div class="absolute left-0 top-0 h-1 w-full bg-gradient-to-r from-primary to-yellow-200"></div>

            <div class="p-8">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Edit User</h2>
                    <a href="{{ route('admin.users.index') }}" class="rounded-full p-2 text-slate-400 hover:bg-gray-100 hover:text-slate-600 dark:hover:bg-white/10">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Full Name</label>
                            <input name="name" value="{{ old('name', $user->name) }}" type="text" class="w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary dark:border-gray-700 dark:bg-input-dark dark:text-white dark:focus:border-primary" required />
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Email Address</label>
                            <input name="email" value="{{ old('email', $user->email) }}" type="email" class="w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary dark:border-gray-700 dark:bg-input-dark dark:text-white dark:focus:border-primary" required />
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password (Optional) -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300">New Password (Leave blank to keep)</label>
                            <input name="password" type="password" class="w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary dark:border-gray-700 dark:bg-input-dark dark:text-white dark:focus:border-primary" />
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Confirm New Password</label>
                            <input name="password_confirmation" type="password" class="w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary dark:border-gray-700 dark:bg-input-dark dark:text-white dark:focus:border-primary" />
                        </div>

                        <!-- Role -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Role</label>
                            <div class="relative">
                                <select name="role_id" class="w-full appearance-none rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm font-medium text-slate-900 focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary dark:border-gray-700 dark:bg-input-dark dark:text-white dark:focus:border-primary" required>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                                    <span class="material-symbols-outlined">expand_more</span>
                                </div>
                            </div>
                            @error('role_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Active Switch -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 block mb-2">Account Status</label>
                            <label class="flex items-center gap-3 cursor-pointer group select-none">
                                <div class="relative flex items-center justify-center w-5 h-5">
                                    <input type="hidden" name="active" value="0">
                                    <input name="active" type="checkbox" value="1" {{ old('active', $user->active) ? 'checked' : '' }} class="peer appearance-none w-5 h-5 border-2 border-[#e6e6db] dark:border-[#6f6e4d] rounded bg-transparent checked:bg-primary checked:border-primary transition-all cursor-pointer" />
                                    <span class="material-symbols-outlined absolute text-black text-sm opacity-0 peer-checked:opacity-100 font-bold pointer-events-none transform scale-75 transition-transform">check</span>
                                </div>
                                <span class="text-sm font-medium text-[#8c8b5f] dark:text-[#cac99d] group-hover:text-[#181811] dark:group-hover:text-white transition-colors">Active User</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">
                        <a href="{{ route('admin.users.index') }}" class="rounded-full px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-gray-100 dark:text-slate-300 dark:hover:bg-white/10 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="rounded-full bg-primary px-6 py-2.5 text-sm font-bold text-black shadow-lg shadow-primary/20 hover:bg-[#e6e205] transition-all">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>