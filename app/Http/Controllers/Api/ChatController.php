<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatbotProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        try {
            $chatHistory = Auth::user()->chats()
                ->with('provider:id,name')
                ->latest()
                ->get()
                ->map(function ($chat) {
                    return [
                        'id' => $chat->id,
                        'message' => $chat->message,
                        'response' => $chat->response,
                        'provider' => [
                            'id' => $chat->provider->id,
                            'name' => $chat->provider->name,
                        ],
                        'created_at' => $chat->created_at->format('Y-m-d H:i:s'),
                    ];
                });

            return response()->json([
                'success' => true,
                'chat_history' => $chatHistory,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching chat history: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching chat history: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function send(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string',
                'provider_id' => 'required|exists:chatbot_providers,id',
            ]);

            $provider = ChatbotProvider::findOrFail($request->provider_id);
            $response = $this->getResponseFromProvider($provider, $request->message);

            $chat = Auth::user()->chats()->create([
                'provider_id' => $provider->id,
                'message' => $request->message,
                'response' => $response,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!',
                'chat' => [
                    'id' => $chat->id,
                    'message' => $chat->message,
                    'response' => $response,
                    'provider' => [
                        'id' => $provider->id,
                        'name' => $provider->name,
                    ],
                    'created_at' => $chat->created_at->format('Y-m-d H:i:s'),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending message: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getProviders()
    {
        try {
            $providers = ChatbotProvider::active()
                ->select('id', 'name', 'is_active', 'endpoint')
                ->get()
                ->map(function ($provider) {
                    return [
                        'id' => $provider->id,
                        'name' => $provider->name,
                        'endpoint' => $provider->endpoint,
                        'is_active' => $provider->is_active,
                    ];
                });

            return response()->json([
                'success' => true,
                'providers' => $providers,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching providers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching providers: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function addProvider(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:chatbot_providers,name',
                'api_key' => 'required|string',
                'endpoint' => 'required|string|url',
                'config' => 'nullable|array',
                'is_active' => 'boolean',
            ]);

            $provider = ChatbotProvider::create([
                'name' => $request->name,
                'api_key' => $request->api_key,
                'endpoint' => $request->endpoint,
                'config' => $request->config ?? [],
                'is_active' => $request->is_active ?? true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Provider added successfully',
                'provider' => [
                    'id' => $provider->id,
                    'name' => $provider->name,
                    'endpoint' => $provider->endpoint,
                    'is_active' => $provider->is_active,
                ],
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error adding provider: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error adding provider: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateProvider(Request $request, $id)
    {
        try {
            $provider = ChatbotProvider::findOrFail($id);

            $request->validate([
                'name' => 'required|string|unique:chatbot_providers,name,' . $id,
                'api_key' => 'required|string',
                'endpoint' => 'required|string|url',
                'config' => 'nullable|array',
                'is_active' => 'boolean',
            ]);

            $provider->update([
                'name' => $request->name,
                'api_key' => $request->api_key,
                'endpoint' => $request->endpoint,
                'config' => $request->config ?? $provider->config,
                'is_active' => $request->is_active ?? $provider->is_active,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Provider updated successfully',
                'provider' => [
                    'id' => $provider->id,
                    'name' => $provider->name,
                    'endpoint' => $provider->endpoint,
                    'is_active' => $provider->is_active,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating provider: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating provider: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteProvider($id)
    {
        try {
            $provider = ChatbotProvider::findOrFail($id);

            // Check if provider has chat history
            if ($provider->chats()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete provider: This provider has existing chat history. Please archive it instead.',
                    'type' => 'warning',
                ], 409);
            }

            $provider->delete();

            return response()->json([
                'success' => true,
                'message' => 'Provider deleted successfully',
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting provider: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting provider: ' . $e->getMessage(),
                'type' => 'error',
            ], 500);
        }
    }

    public function toggleProvider($id)
    {
        try {
            $provider = ChatbotProvider::findOrFail($id);

            if ($provider->toggleActive()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Provider status updated successfully',
                    'provider' => [
                        'id' => $provider->id,
                        'name' => $provider->name,
                        'is_active' => $provider->is_active,
                    ],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to update provider status',
            ], 500);

        } catch (\Exception $e) {
            Log::error('Error toggling provider: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error toggling provider: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function getResponseFromProvider(ChatbotProvider $provider, string $message)
    {
        $client = new Client();

        switch ($provider->name) {
            case 'OpenAI':
                return $this->getOpenAIResponse($client, $provider, $message);
            case 'Anthropic':
                return $this->getAnthropicResponse($client, $provider, $message);
            case 'Gemini':
                return $this->getGeminiResponse($client, $provider, $message);
            case 'DeepSeek':
                return $this->getDeepSeekResponse($client, $provider, $message);
            default:
                throw new \Exception('Unsupported provider');
        }
    }

    private function getDeepSeekResponse($client, $provider, $message)
    {
        try {
            $response = $client->post($provider->endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $provider->api_key,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $message,
                        ],
                    ],
                    'temperature' => $provider->config['temperature'] ?? 0.7,
                    'max_tokens' => $provider->config['max_tokens'] ?? 1000,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['choices'][0]['message']['content'] ?? 'No response';

        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $errorBody = $response ? $response->getBody()->getContents() : '';
            Log::error('DeepSeek API Error: ' . $errorBody);
            throw new \Exception('DeepSeek API Error: ' . $e->getMessage());
        }
    }

    private function getOpenAIResponse($client, $provider, $message)
    {
        try {
            $response = $client->post($provider->endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $provider->api_key,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => $message],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 1000,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['choices'][0]['message']['content'] ?? 'No response';

        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $errorBody = $response ? $response->getBody()->getContents() : '';
            Log::error('OpenAI API Error: ' . $errorBody);
            throw new \Exception('OpenAI API Error: ' . $e->getMessage());
        }
    }

    private function getAnthropicResponse($client, $provider, $message)
    {
        try {
            $response = $client->post($provider->endpoint, [
                'headers' => [
                    'x-api-key' => $provider->api_key,
                    'anthropic-version' => '2023-06-01',
                    'content-type' => 'application/json',
                ],
                'json' => [
                    'model' => 'claude-3-sonnet-20240229',
                    'max_tokens' => 1000,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $message,
                        ],
                    ],
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['content'][0]['text'] ?? 'No response';

        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $errorBody = $response ? $response->getBody()->getContents() : '';
            Log::error('Anthropic API Error: ' . $errorBody);
            throw new \Exception('Anthropic API Error: ' . $e->getMessage());
        }
    }

    private function getGeminiResponse($client, $provider, $message)
    {
        try {
            $response = $client->post($provider->endpoint . '?key=' . $provider->api_key, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $message],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 1000,
                    ],
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['candidates'][0]['content']['parts'][0]['text'] ?? 'No response';

        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $errorBody = $response ? $response->getBody()->getContents() : '';
            Log::error('Gemini API Error: ' . $errorBody);
            throw new \Exception('Gemini API Error: ' . $e->getMessage());
        }
    }
}
