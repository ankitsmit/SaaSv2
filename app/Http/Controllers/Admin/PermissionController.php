<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Submodule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::with('module', 'submodule')->paginate(15);
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = Module::where('is_active', true)->with('submodules')->get();
        return view('admin.permissions.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:permissions',
            'type' => 'required|in:module,submodule',
            'module_id' => 'nullable|exists:modules,id',
            'submodule_id' => 'nullable|exists:submodules,id',
            'description' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Permission::create($validated);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $permission->load('module', 'submodule');
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $modules = Module::where('is_active', true)->with('submodules')->get();
        return view('admin.permissions.edit', compact('permission', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:permissions,slug,' . $permission->id,
            'type' => 'required|in:module,submodule',
            'module_id' => 'nullable|exists:modules,id',
            'submodule_id' => 'nullable|exists:submodules,id',
            'description' => 'nullable|string',
        ]);

        $permission->update($validated);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
