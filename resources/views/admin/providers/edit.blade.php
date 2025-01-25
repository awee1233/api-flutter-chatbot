<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Provider') }}: {{ $provider->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.providers.update', $provider) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Provider Name</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror"
                                value="{{ old('name', $provider->name) }}" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- API Key (Optional) -->
                        <div class="mb-4">
                            <label for="api_key" class="block text-sm font-medium text-gray-700">
                                API Key (Optional)
                            </label>
                            <input type="password" name="api_key" id="api_key"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('api_key') border-red-500 @enderror"
                                placeholder="Leave blank to keep current API key">
                            <p class="mt-1 text-sm text-gray-500">Leave blank to keep the current API key</p>
                            @error('api_key')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Endpoint -->
                        <div class="mb-4">
                            <label for="endpoint" class="block text-sm font-medium text-gray-700">API Endpoint</label>
                            <input type="url" name="endpoint" id="endpoint"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('endpoint') border-red-500 @enderror"
                                value="{{ old('endpoint', $provider->endpoint) }}" required>
                            @error('endpoint')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Configuration -->
                        <div class="mb-4">
                            <label for="config" class="block text-sm font-medium text-gray-700">Configuration (JSON)</label>
                            <textarea name="config" id="config" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('config') border-red-500 @enderror"
                            >{{ old('config', json_encode($provider->config, JSON_PRETTY_PRINT)) }}</textarea>
                            @error('config')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active"
                                    class="text-blue-600 rounded border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    value="1" {{ old('is_active', $provider->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Active</span>
                            </label>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end items-center mt-6">
                            <a href="{{ route('admin.providers.index') }}"
                                class="px-4 py-2 mr-2 text-white bg-gray-500 rounded-md hover:bg-gray-600">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Update Provider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
