<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotProvider;
use Illuminate\Http\Request;

class ProviderController extends Controller
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
            'config' => 'required|json',
            'is_active' => 'boolean'
        ]);

        $data = $validated;
        $data['config'] = json_decode($request->config, true);
        $data['is_active'] = (bool) $request->input('is_active', false);

        ChatbotProvider::create($data);

        return redirect()
            ->route('admin.providers.index')
            ->with('success', 'Provider created successfully');
    }

    public function edit(ChatbotProvider $provider)
    {
        return view('admin.providers.edit', compact('provider'));
    }

    public function update(Request $request, ChatbotProvider $provider)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'endpoint' => 'required|url',
            'config' => 'required|json',
            'is_active' => 'boolean',
            'api_key' => 'nullable|string'
        ];

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['name'],
            'endpoint' => $validated['endpoint'],
            'config' => json_decode($validated['config'], true),
            'is_active' => (bool) $request->input('is_active', false)
        ];

        if ($request->filled('api_key')) {
            $data['api_key'] = $validated['api_key'];
        }

        $provider->update($data);

        return redirect()
            ->route('admin.providers.index')
            ->with('success', 'Provider updated successfully');
    }

    public function destroy(ChatbotProvider $provider)
    {
        $provider->delete();

        return redirect()
            ->route('admin.providers.index')
            ->with('success', 'Provider deleted successfully');
    }
}
