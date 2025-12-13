<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Application') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.apps.update', $app) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('App Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $app->name)" required autofocus />
                        </div>

                        <!-- Slug -->
                        <div class="mt-4">
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug', $app->slug)" required />
                        </div>

                        <!-- URL -->
                        <div class="mt-4">
                            <x-input-label for="url" :value="__('Target URL')" />
                            <x-text-input id="url" class="block mt-1 w-full text-gray-900" type="url" name="url" :value="old('url', $app->url)" required />
                        </div>

                        <!-- Icon -->
                        <div class="mt-4">
                            <x-input-label for="icon" :value="__('Icon')" />
                            <x-text-input id="icon" class="block mt-1 w-full" type="text" name="icon" :value="old('icon', $app->icon)" />
                        </div>

                        <!-- Role -->
                        <div class="mt-4">
                            <x-input-label for="role_id" :value="__('Restrict to Role')" />
                            <select id="role_id" name="role_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">-- Open to all Registered Users --</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $app->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Active -->
                        <div class="block mt-4">
                            <label for="active" class="inline-flex items-center">
                                <input id="active" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="active" {{ $app->active ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Visible / Active') }}</span>
                            </label>
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('description', $app->description) }}</textarea>
                        </div>


                        <div class="flex items-center justify-between mt-4">
                            <button type="button" form="delete-form" class="text-red-500 hover:text-red-700 underline text-sm">Delete App</button>

                            <x-primary-button class="ml-4">
                                {{ __('Update App') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <form id="delete-form" action="{{ route('admin.apps.destroy', $app) }}" method="POST" class="hidden" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>