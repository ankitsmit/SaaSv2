@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-base-content text-3xl font-bold">{{ $submodule->name }}</h1>
                <p class="text-base-content/70 mt-1">Submodule Details</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.submodules.edit', $submodule) }}" class="btn btn-outline">
                    <span class="icon-[tabler--pencil] size-5"></span>
                    Edit
                </a>
                <a href="{{ route('admin.submodules.index') }}" class="btn btn-text">
                    Back to List
                </a>
            </div>
        </div>

        <!-- Submodule Info -->
        <div class="bg-base-100 shadow-base-300/20 rounded-xl p-6 shadow-md">
            <h2 class="text-base-content mb-4 text-xl font-semibold">Submodule Information</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Name</label>
                    <p class="text-base-content mt-1">{{ $submodule->name }}</p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Module</label>
                    <p class="text-base-content mt-1">{{ $submodule->module->name }}</p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Slug</label>
                    <p class="text-base-content mt-1"><code>{{ $submodule->slug }}</code></p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Route</label>
                    <p class="text-base-content mt-1"><code>{{ $submodule->route ?? 'N/A' }}</code></p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Icon</label>
                    <p class="mt-1">
                        @if ($submodule->icon)
                            <span class="icon-[tabler--{{ $submodule->icon }}] size-5"></span>
                        @else
                            <span class="text-base-content/50">N/A</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Order</label>
                    <p class="text-base-content mt-1">{{ $submodule->order }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-base-content/70 text-sm font-medium">Description</label>
                    <p class="text-base-content mt-1">{{ $submodule->description ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Status</label>
                    <p class="mt-1">
                        @if ($submodule->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-error">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
