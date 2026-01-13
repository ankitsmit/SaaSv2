@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-base-content text-3xl font-bold">{{ $permission->name }}</h1>
                <p class="text-base-content/70 mt-1">Permission Details</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-outline">
                    <span class="icon-[tabler--pencil] size-5"></span>
                    Edit
                </a>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-text">
                    Back to List
                </a>
            </div>
        </div>

        <!-- Permission Info -->
        <div class="bg-base-100 shadow-base-300/20 rounded-xl p-6 shadow-md">
            <h2 class="text-base-content mb-4 text-xl font-semibold">Permission Information</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Name</label>
                    <p class="text-base-content mt-1">{{ $permission->name }}</p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Slug</label>
                    <p class="text-base-content mt-1"><code>{{ $permission->slug }}</code></p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Type</label>
                    <p class="mt-1">
                        <span class="badge">{{ $permission->type }}</span>
                    </p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">{{ $permission->type === 'module' ? 'Module' : 'Submodule' }}</label>
                    <p class="text-base-content mt-1">
                        @if ($permission->type === 'module' && $permission->module)
                            {{ $permission->module->name }}
                        @elseif ($permission->type === 'submodule' && $permission->submodule)
                            {{ $permission->submodule->name }} ({{ $permission->submodule->module->name }})
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-base-content/70 text-sm font-medium">Description</label>
                    <p class="text-base-content mt-1">{{ $permission->description ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
