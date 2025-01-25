<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotProvider;
use Illuminate\Http\Request;

class ChatbotProviderController extends Controller
{
    public function index()
    {
        $providers = ChatbotProvider::all();
        return view('admin.providers.index', compact('providers'));
    }

    public function create()
    {
        return view('admin.providers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string',
            'endpoint' => 'required|url',
            'config' => 'nullable|json',
            'is_active' => 'boolean'
        ]);

        ChatbotProvider::create($validated);

        return redirect()->route('admin.providers.index')
            ->with('success', 'Provider created successfully.');
    }

    public function edit(ChatbotProvider $provider)
    {
        return view('admin.providers.edit', compact('provider'));
    }

    public function update(Request $request, ChatbotProvider $provider)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string',
            'endpoint' => 'required|url',
            'config' => 'nullable|json',
            'is_active' => 'boolean'
        ]);

        $provider->update($validated);

        return redirect()->route('admin.providers.index')
            ->with('success', 'Provider updated successfully.');
    }

    public function destroy(ChatbotProvider $provider)
    {
        $provider->delete();
        return redirect()->route('admin.providers.index')
            ->with('success', 'Provider deleted successfully.');
    }
}
