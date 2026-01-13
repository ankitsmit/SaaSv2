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
                <h1 class="text-base-content text-3xl font-bold">Modules</h1>
                <p class="text-base-content/70 mt-1">Manage all system modules</p>
            </div>
            <a href="{{ route('admin.modules.create') }}" class="btn btn-primary">
                <span class="icon-[tabler--plus] size-5"></span>
                Add Module
            </a>
        </div>

        <div class="rounded-box shadow-base-300/10 bg-base-100 w-full pb-2 shadow-md">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Icon</th>
                            <th>Submodules</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($modules as $module)
                            <tr>
                                <td>{{ $module->name }}</td>
                                <td><code class="text-xs">{{ $module->slug }}</code></td>
                                <td>
                                    @if ($module->icon)
                                        <span class="icon-[tabler--{{ $module->icon }}] size-5"></span>
                                    @else
                                        <span class="text-base-content/50">-</span>
                                    @endif
                                </td>
                                <td>{{ $module->submodules->count() }}</td>
                                <td>{{ $module->order }}</td>
                                <td>
                                    @if ($module->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-error">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.modules.show', $module) }}" class="btn btn-circle btn-text btn-sm" aria-label="View module">
                                            <span class="icon-[tabler--eye] size-5"></span>
                                        </a>
                                        <a href="{{ route('admin.modules.edit', $module) }}" class="btn btn-circle btn-text btn-sm" aria-label="Edit module">
                                            <span class="icon-[tabler--pencil] size-5"></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8">
                                    <p class="text-base-content/70">No modules found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($modules->hasPages())
            <div class="mt-4">
                {{ $modules->links() }}
            </div>
        @endif
    </div>
@endsection
