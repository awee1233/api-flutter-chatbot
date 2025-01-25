<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Provider Details') }}: {{ $provider->name }}
            </h2>
            <div>
                <a href="{{ route('admin.providers.edit', $provider) }}" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mr-2">
                    Edit
                </a>
                <a href="{{ route('admin.providers.index') }}" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Name -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Provider Name</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $provider->name }}</dd>
                        </div>

                        <!-- Status -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $provider->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $provider->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </dd>
                        </div>

                        <!-- Endpoint -->
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">API Endpoint</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $provider->endpoint }}</dd>
                        </div>

                        <!-- Configuration -->
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Configuration</dt>
                            <dd class="mt-1">
                                <pre class="bg-gray-50 p-4 rounded-md overflow-x-auto">{{ json_encode($provider->config, JSON_PRETTY_PRINT) }}</pre>
                            </dd>
                        </div>

                        <!-- Created At -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $provider->created_at->format('M d, Y H:i') }}</dd>
                        </div>

                        <!-- Updated At -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $provider->updated_at->format('M d, Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
