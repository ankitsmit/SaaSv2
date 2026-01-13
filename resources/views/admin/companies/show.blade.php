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
                <h1 class="text-base-content text-3xl font-bold">{{ $company->name }}</h1>
                <p class="text-base-content/70 mt-1">Company Details & Module Management</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.companies.edit', $company) }}" class="btn btn-outline">
                    <span class="icon-[tabler--pencil] size-5"></span>
                    Edit
                </a>
                <a href="{{ route('admin.companies.index') }}" class="btn btn-text">
                    Back to List
                </a>
            </div>
        </div>

        <!-- Company Info -->
        <div class="bg-base-100 shadow-base-300/20 rounded-xl p-6 shadow-md">
            <h2 class="text-base-content mb-4 text-xl font-semibold">Company Information</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Name</label>
                    <p class="text-base-content mt-1">{{ $company->name }}</p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Slug</label>
                    <p class="text-base-content mt-1"><code>{{ $company->slug }}</code></p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Email</label>
                    <p class="text-base-content mt-1">{{ $company->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Phone</label>
                    <p class="text-base-content mt-1">{{ $company->phone ?? 'N/A' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-base-content/70 text-sm font-medium">Address</label>
                    <p class="text-base-content mt-1">{{ $company->address ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="text-base-content/70 text-sm font-medium">Status</label>
                    <p class="mt-1">
                        @if ($company->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-error">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Module Assignment -->
        <div class="bg-base-100 shadow-base-300/20 rounded-xl p-6 shadow-md">
            <h2 class="text-base-content mb-4 text-xl font-semibold">Module Assignment</h2>
            <div class="space-y-4">
                @forelse ($allModules as $module)
                    <div class="border-base-300 rounded-lg border p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div>
                                    <h3 class="text-base-content font-semibold">{{ $module->name }}</h3>
                                    @if ($module->description)
                                        <p class="text-base-content/70 text-sm">{{ $module->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @php
                                    $isAssigned = $company->modules->contains($module->id);
                                    $pivotData = $isAssigned ? $company->modules->find($module->id)->pivot : null;
                                @endphp
                                
                                @if ($isAssigned)
                                    <form action="{{ route('admin.companies.modules.toggle', [$company, $module]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $pivotData->is_active ? 'btn-success' : 'btn-warning' }}">
                                            {{ $pivotData->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.companies.modules.remove', [$company, $module]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to remove this module?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error">Remove</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.companies.modules.assign', [$company, $module]) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Assign</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        
                        @if ($isAssigned && $module->submodules->count() > 0)
                            <div class="mt-3 border-t border-base-300 pt-3">
                                <p class="text-base-content/70 mb-2 text-sm font-medium">Submodules:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($module->submodules as $submodule)
                                        <span class="badge">{{ $submodule->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-base-content/70 text-center py-8">No modules available. <a href="{{ route('admin.modules.create') }}" class="text-primary">Create one</a></p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
