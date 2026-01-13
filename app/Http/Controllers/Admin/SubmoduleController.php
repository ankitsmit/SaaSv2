<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Submodule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubmoduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submodules = Submodule::with('module')->orderBy('order')->paginate(15);
        return view('admin.submodules.index', compact('submodules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = Module::where('is_active', true)->get();
        return view('admin.submodules.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'config' => 'nullable|array',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Submodule::create($validated);

        return redirect()->route('admin.submodules.index')->with('success', 'Submodule created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Submodule $submodule)
    {
        $submodule->load('module', 'permissions');
        return view('admin.submodules.show', compact('submodule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submodule $submodule)
    {
        $modules = Module::where('is_active', true)->get();
        return view('admin.submodules.edit', compact('submodule', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submodule $submodule)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'config' => 'nullable|array',
        ]);

        $submodule->update($validated);

        return redirect()->route('admin.submodules.index')->with('success', 'Submodule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submodule $submodule)
    {
        $submodule->delete();
        return redirect()->route('admin.submodules.index')->with('success', 'Submodule deleted successfully.');
    }
}
