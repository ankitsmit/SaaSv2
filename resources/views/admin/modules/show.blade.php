@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-base-content text-3xl font-bold">{{ $module->name }}</h1>
                <p class="text-base-content/70 mt-1">Module Details</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.modules.edit', $module) }}" class="btn btn-outline">
                    <span class="icon-[tabler--pencil] size-5"></span>
                    Edit
                </a>
                <a href="{{ route('admin.modules.index') }}" class="btn btn-text">
                    Back to List
                </a>
            </div>
        </div>

        <!-- Module Info -->
        <div class="bg-base-100 shadow-base-300/20 rounded-xl p-6 shadow-md">
            <h2 class="text-base-content mb-4 text-xl font-semibold">Module Information</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Name</label>
                    <p class="text-base-content mt-1">{{ $module->name }}</p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Slug</label>
                    <p class="text-base-content mt-1"><code>{{ $module->slug }}</code></p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Icon</label>
                    <p class="mt-1">
                        @if ($module->icon)
                            <span class="icon-[tabler--{{ $module->icon }}] size-5"></span>
                        @else
                            <span class="text-base-content/50">N/A</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Order</label>
                    <p class="text-base-content mt-1">{{ $module->order }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-base-content/70 text-sm font-medium">Description</label>
                    <p class="text-base-content mt-1">{{ $module->description ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Status</label>
                    <p class="mt-1">
                        @if ($module->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-error">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Submodules -->
        <div class="bg-base-100 shadow-base-300/20 rounded-xl p-6 shadow-md">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base-content text-xl font-semibold">Submodules ({{ $module->submodules->count() }})</h2>
                <a href="{{ route('admin.submodules.create', ['module_id' => $module->id]) }}" class="btn btn-sm btn-primary">
                    <span class="icon-[tabler--plus] size-4"></span>
                    Add Submodule
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Route</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($module->submodules as $submodule)
                            <tr>
                                <td>{{ $submodule->name }}</td>
                                <td><code class="text-xs">{{ $submodule->slug }}</code></td>
                                <td><code class="text-xs">{{ $submodule->route ?? 'N/A' }}</code></td>
                                <td>{{ $submodule->order }}</td>
                                <td>
                                    @if ($submodule->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-error">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.submodules.edit', $submodule) }}" class="btn btn-circle btn-text btn-sm" aria-label="Edit submodule">
                                        <span class="icon-[tabler--pencil] size-5"></span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8">
                                    <p class="text-base-content/70">No submodules found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
