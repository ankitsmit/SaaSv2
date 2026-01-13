@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-base-content text-3xl font-bold">Dashboard</h1>
            <p class="text-base-content/70 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
        </div>

        @php
            $user = auth()->user();
            $company = $user->company;
            $assignedModules = $company ? $company->modules()->wherePivot('is_active', true)->get() : collect();
        @endphp

        @if ($company)
            <!-- Company Info -->
            <div class="shadow-base-300/10 rounded-box bg-base-100 p-6 shadow-md">
                <h2 class="text-base-content mb-4 text-xl font-semibold">{{ $company->name }}</h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-base-content/70 text-sm font-medium">Email</label>
                        <p class="text-base-content mt-1">{{ $company->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-base-content/70 text-sm font-medium">Phone</label>
                        <p class="text-base-content mt-1">{{ $company->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-base-content/70 text-sm font-medium">Assigned Modules</label>
                        <p class="text-base-content mt-1">{{ $assignedModules->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Assigned Modules -->
            @if ($assignedModules->count() > 0)
                <div class="shadow-base-300/10 rounded-box bg-base-100 p-6 shadow-md">
                    <h2 class="text-base-content mb-4 text-xl font-semibold">Available Modules</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($assignedModules as $module)
                            @php
                                $assignedSubmodules = $company->submodules()
                                    ->where('submodules.module_id', $module->id)
                                    ->wherePivot('is_active', true)
                                    ->get();
                            @endphp
                            <div class="border-base-300 rounded-lg border p-4">
                                <div class="mb-2 flex items-center gap-2">
                                    @if ($module->icon)
                                        <span class="icon-[tabler--{{ $module->icon }}] size-5"></span>
                                    @endif
                                    <h3 class="text-base-content font-semibold">{{ $module->name }}</h3>
                                </div>
                                @if ($module->description)
                                    <p class="text-base-content/70 mb-3 text-sm">{{ $module->description }}</p>
                                @endif
                                
                                @if ($assignedSubmodules->count() > 0)
                                    <div class="space-y-2">
                                        <p class="text-base-content/70 text-xs font-medium">Submodules:</p>
                                        <div class="flex flex-col gap-1">
                                            @foreach ($assignedSubmodules as $submodule)
                                                @if ($submodule->route && Route::has($submodule->route))
                                                    <a href="{{ route($submodule->route) }}" class="text-primary hover:text-primary/80 text-sm">
                                                        → {{ $submodule->name }}
                                                    </a>
                                                @else
                                                    <span class="text-base-content/50 text-sm">{{ $submodule->name }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <p class="text-base-content/50 text-xs">No submodules available</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="shadow-base-300/10 rounded-box bg-base-100 p-6 shadow-md">
                    <div class="text-center py-8">
                        <p class="text-base-content/70">No modules have been assigned to your company yet.</p>
                        <p class="text-base-content/50 mt-2 text-sm">Please contact the administrator to get access to modules.</p>
                    </div>
                </div>
            @endif
        @else
            <div class="shadow-base-300/10 rounded-box bg-base-100 p-6 shadow-md">
                <div class="text-center py-8">
                    <p class="text-base-content/70">No company associated with your account.</p>
                    <p class="text-base-content/50 mt-2 text-sm">Please contact the administrator.</p>
                </div>
            </div>
        @endif

        <!-- Stats -->
        <div class="shadow-base-300/10 rounded-box bg-base-100 grid grid-cols-1 gap-4 p-6 shadow-md md:grid-cols-3">
            <div class="flex flex-col gap-4">
                <div class="text-base-content flex items-center gap-2">
                    <div class="avatar avatar-placeholder">
                        <div class="bg-base-200 rounded-field size-9">
                            <span class="icon-[tabler--apps] size-5"></span>
                        </div>
                    </div>
                    <h5 class="text-lg font-medium">Modules</h5>
                </div>
                <div>
                    <div class="text-base-content text-xl font-semibold">{{ $assignedModules->count() }}</div>
                    <div class="text-base-content/50 text-sm font-medium">Assigned Modules</div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <div class="text-base-content flex items-center gap-2">
                    <div class="avatar avatar-placeholder">
                        <div class="bg-base-200 rounded-field size-9">
                            <span class="icon-[tabler--components] size-5"></span>
                        </div>
                    </div>
                    <h5 class="text-lg font-medium">Submodules</h5>
                </div>
                <div>
                    <div class="text-base-content text-xl font-semibold">
                        {{ $company ? $company->submodules()->wherePivot('is_active', true)->count() : 0 }}
                    </div>
                    <div class="text-base-content/50 text-sm font-medium">Available Submodules</div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <div class="text-base-content flex items-center gap-2">
                    <div class="avatar avatar-placeholder">
                        <div class="bg-base-200 rounded-field size-9">
                            <span class="icon-[tabler--user] size-5"></span>
                        </div>
                    </div>
                    <h5 class="text-lg font-medium">Account</h5>
                </div>
                <div>
                    <div class="text-base-content text-xl font-semibold">{{ $company ? $company->users->count() : 0 }}</div>
                    <div class="text-base-content/50 text-sm font-medium">Company Users</div>
                </div>
            </div>
        </div>
    </div>
@endsection
