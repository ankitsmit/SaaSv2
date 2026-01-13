@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        @session('success')
            <x-ui.alert variant="success">
                {{ $value }}
            </x-ui.alert>
        @endsession

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-base-content text-3xl font-bold">Permissions</h1>
                <p class="text-base-content/70 mt-1">Manage all system permissions</p>
            </div>
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                <span class="icon-[tabler--plus] size-5"></span>
                Add Permission
            </a>
        </div>

        <div class="rounded-box shadow-base-300/10 bg-base-100 w-full pb-2 shadow-md">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Type</th>
                            <th>Module</th>
                            <th>Submodule</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td><code class="text-xs">{{ $permission->slug }}</code></td>
                                <td>
                                    <span class="badge">{{ $permission->type }}</span>
                                </td>
                                <td>{{ $permission->module->name ?? 'N/A' }}</td>
                                <td>{{ $permission->submodule->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.permissions.show', $permission) }}" class="btn btn-circle btn-text btn-sm" aria-label="View permission">
                                            <span class="icon-[tabler--eye] size-5"></span>
                                        </a>
                                        <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-circle btn-text btn-sm" aria-label="Edit permission">
                                            <span class="icon-[tabler--pencil] size-5"></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8">
                                    <p class="text-base-content/70">No permissions found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($permissions->hasPages())
            <div class="mt-4">
                {{ $permissions->links() }}
            </div>
        @endif
    </div>
@endsection
