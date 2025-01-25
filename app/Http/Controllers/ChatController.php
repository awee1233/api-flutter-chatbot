<?php

namespace App\Http\Controllers;

use App\Models\ChatbotProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ChatController extends Controller
{
    public function index()
    {
        $providers = ChatbotProvider::where('is_active', true)->get();
        $chatHistory = Auth::user()->chats()->with('provider')->latest()->get();
        return view('chat.index', compact('providers', 'chatHistory'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'provider_id' => 'required|exists:chatbot_providers,id'
        ]);

        $provider = ChatbotProvider::findOrFail($request->provider_id);

        try {
            $response = $this->getResponseFromProvider($provider, $request->message);

            Auth::user()->chats()->create([
                'provider_id' => $provider->id,
                'message' => $request->message,
                'response' => $response,
            ]);

            return redirect()->route('chat')->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            return redirect()->route('chat')->with('error', 'Error: ' . $e->getMessage());
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
                            'content' => $message
                        ]
                    ],
                    'temperature' => $provider->config['temperature'] ?? 0.7,
                    'max_tokens' => $provider->config['max_tokens'] ?? 1000,
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['choices'][0]['message']['content'] ?? 'No response';

        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $errorBody = $response ? $response->getBody()->getContents() : '';
            \Log::error('DeepSeek API Error: ' . $errorBody);

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
                        ['role' => 'user', 'content' => $message]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 1000,
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['choices'][0]['message']['content'] ?? 'No response';

        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $errorBody = $response ? $response->getBody()->getContents() : '';
            \Log::error('OpenAI API Error: ' . $errorBody);

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
                            'content' => $message
                        ]
                    ]
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['content'][0]['text'] ?? 'No response';

        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $errorBody = $response ? $response->getBody()->getContents() : '';
            \Log::error('Anthropic API Error: ' . $errorBody);

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
                                ['text' => $message]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 1000,
                    ],
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['candidates'][0]['content']['parts'][0]['text'] ?? 'No response';

        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $errorBody = $response ? $response->getBody()->getContents() : '';
            \Log::error('Gemini API Error: ' . $errorBody);

            throw new \Exception('Gemini API Error: ' . $e->getMessage());
        }
    }
}
