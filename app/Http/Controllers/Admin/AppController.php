<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Role;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        $apps = App::with('role')->paginate(10);
        return view('admin.apps.index', compact('apps'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.apps.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:apps',
            'url' => 'required|url',
            'icon' => 'nullable|string',
            'role_id' => 'nullable|exists:roles,id',
            'description' => 'nullable|string',
        ]);

        $validated['active'] = true;

        App::create($validated);

        return redirect()->route('admin.apps.index')->with('success', 'App registered successfully.');
    }

    public function edit(App $app)
    {
        $roles = Role::all();
        return view('admin.apps.edit', compact('app', 'roles'));
    }

    public function update(Request $request, App $app)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:apps,slug,' . $app->id,
            'url' => 'required|url',
            'icon' => 'nullable|string',
            'role_id' => 'nullable|exists:roles,id',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        // Checkbox logic
        $validated['active'] = $request->has('active');

        $app->update($validated);

        return redirect()->route('admin.apps.index')->with('success', 'App updated successfully.');
    }

    public function destroy(App $app)
    {
        $app->delete();
        return redirect()->route('admin.apps.index')->with('success', 'App deleted.');
    }
}
