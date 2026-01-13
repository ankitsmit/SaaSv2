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
                <h1 class="text-base-content text-3xl font-bold">Submodules</h1>
                <p class="text-base-content/70 mt-1">Manage all system submodules</p>
            </div>
            <a href="{{ route('admin.submodules.create') }}" class="btn btn-primary">
                <span class="icon-[tabler--plus] size-5"></span>
                Add Submodule
            </a>
        </div>

        <div class="rounded-box shadow-base-300/10 bg-base-100 w-full pb-2 shadow-md">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Module</th>
                            <th>Slug</th>
                            <th>Route</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submodules as $submodule)
                            <tr>
                                <td>{{ $submodule->name }}</td>
                                <td>{{ $submodule->module->name }}</td>
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
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.submodules.show', $submodule) }}" class="btn btn-circle btn-text btn-sm" aria-label="View submodule">
                                            <span class="icon-[tabler--eye] size-5"></span>
                                        </a>
                                        <a href="{{ route('admin.submodules.edit', $submodule) }}" class="btn btn-circle btn-text btn-sm" aria-label="Edit submodule">
                                            <span class="icon-[tabler--pencil] size-5"></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8">
                                    <p class="text-base-content/70">No submodules found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($submodules->hasPages())
            <div class="mt-4">
                {{ $submodules->links() }}
            </div>
        @endif
    </div>
@endsection
