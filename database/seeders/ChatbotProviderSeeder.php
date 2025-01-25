<?php

namespace Database\Seeders;

use App\Models\ChatbotProvider;
use Illuminate\Database\Seeder;

class ChatbotProviderSeeder extends Seeder
{
    public function run(): void
    {
        ChatbotProvider::create([
            'name' => 'OpenAI',
            'api_key' => env('OPENAI_API_KEY'),
            'endpoint' => 'https://api.openai.com/v1/chat/completions',
            'config' => [
                'model' => 'gpt-3.5-turbo',
                'temperature' => 0.7,
            ],
            'is_active' => true,
        ]);

        ChatbotProvider::create([
            'name' => 'Anthropic',
            'api_key' => env('ANTHROPIC_API_KEY'),
            'endpoint' => 'https://api.anthropic.com/v1/messages',
            'config' => [
                'model' => 'claude-3-sonnet-20240229',
            ],
            'is_active' => true,
        ]);

        ChatbotProvider::create([
            'name' => 'Gemini',
            'api_key' => env('GEMINI_API_KEY'),
            'endpoint' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent',
            'config' => [],
            'is_active' => true,
        ]);

        ChatbotProvider::create([
            'name' => 'DeepSeek',
            'api_key' => env('DEEPSEEK_API_KEY'),
            'endpoint' => 'https://api.deepseek.com/v1/chat/completions',
            'config' => [
                'model' => 'deepseek-chat',
                'temperature' => 0.7,
                'max_tokens' => 1000,
            ],
            'is_active' => true,
        ]);
    }
}
