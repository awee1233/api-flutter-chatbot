<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Chat Interface') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <!-- Chat History -->
                        <div class="md:col-span-2">
                            <h3 class="mb-4 text-lg font-semibold">Chat History</h3>
                            <div class="space-y-4 max-h-[600px] overflow-y-auto">
                                @forelse($chatHistory as $chat)
                                    <div class="p-4 bg-gray-50 rounded-lg">
                                        <div class="mb-3">
                                            <p class="text-sm text-gray-500">{{ $chat->created_at->format('M d, Y H:i') }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="font-medium text-blue-600">You:</p>
                                            <p class="ml-4 text-gray-700">{{ $chat->message }}</p>
                                        </div>
                                        <div>
                                            <p class="font-medium text-green-600">Bot:</p>
                                            <p class="ml-4 text-gray-700">{{ $chat->response }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No chat history yet. Start a conversation!</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Chat Form -->
                        <div class="p-6 bg-gray-50 rounded-lg">
                            <h3 class="mb-4 text-lg font-semibold">New Message</h3>
                            <form action="{{ route('chat.send') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="provider" class="block mb-2 text-sm font-medium text-gray-700">
                                        Select Provider
                                    </label>
                                    <select name="provider_id" id="provider" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="message" class="block mb-2 text-sm font-medium text-gray-700">
                                        Your Message
                                    </label>
                                    <textarea
                                        name="message"
                                        id="message"
                                        rows="4"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required
                                    ></textarea>
                                </div>

                                <button type="submit" class="px-4 py-2 w-full text-white bg-blue-600 rounded-md transition duration-150 hover:bg-blue-700">
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
// lib/models/chat_provider.dart
class ChatProvider {
  final int id;
  final String name;
  final bool isActive;

  ChatProvider({
    required this.id,
    required this.name,
    required this.isActive,
  });

  factory ChatProvider.fromJson(Map<String, dynamic> json) {
    return ChatProvider(
      id: json['id'],
      name: json['name'],
      isActive: json['is_active'],
    );
  }
}
