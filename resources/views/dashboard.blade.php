<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome to Chatbot System</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Chat Section -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="font-medium mb-2">Quick Chat</h4>
                            <p class="text-gray-600 mb-4">Start a conversation with our AI chatbot.</p>
                            <a href="{{ route('chat') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Start Chat
                            </a>
                        </div>

                        @if(auth()->user()->isAdmin())
                        <!-- Admin Section -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="font-medium mb-2">Provider Management</h4>
                            <p class="text-gray-600 mb-4">Manage your chatbot providers and configurations.</p>
                            <a href="{{ route('admin.providers.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Manage Providers
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
