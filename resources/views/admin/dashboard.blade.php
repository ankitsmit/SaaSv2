@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-base-content text-3xl font-bold">Admin Dashboard</h1>
            <p class="text-base-content/70 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
        </div>

        <!-- Stats -->
        <div class="shadow-base-300/10 rounded-box bg-base-100 grid grid-cols-1 gap-4 p-6 shadow-md md:grid-cols-2 lg:grid-cols-4">
            <div class="flex flex-col gap-4">
                <div class="text-base-content flex items-center gap-2">
                    <div class="avatar avatar-placeholder">
                        <div class="bg-base-200 rounded-field size-9">
                            <span class="icon-[tabler--building] size-5"></span>
                        </div>
                    </div>
                    <h5 class="text-lg font-medium">Companies</h5>
                </div>
                <div>
                    <div class="text-base-content text-xl font-semibold">{{ \App\Models\Company::count() }}</div>
                    <div class="text-base-content/50 text-sm font-medium">Total Companies</div>
                </div>
            </div>

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
                    <div class="text-base-content text-xl font-semibold">{{ \App\Models\Module::count() }}</div>
                    <div class="text-base-content/50 text-sm font-medium">Total Modules</div>
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
                    <div class="text-base-content text-xl font-semibold">{{ \App\Models\Submodule::count() }}</div>
                    <div class="text-base-content/50 text-sm font-medium">Total Submodules</div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <div class="text-base-content flex items-center gap-2">
                    <div class="avatar avatar-placeholder">
                        <div class="bg-base-200 rounded-field size-9">
                            <span class="icon-[tabler--users] size-5"></span>
                        </div>
                    </div>
                    <h5 class="text-lg font-medium">Users</h5>
                </div>
                <div>
                    <div class="text-base-content text-xl font-semibold">{{ \App\Models\User::where('user_type', 'client')->count() }}</div>
                    <div class="text-base-content/50 text-sm font-medium">Client Users</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="shadow-base-300/10 rounded-box bg-base-100 p-6 shadow-md">
            <h2 class="text-base-content mb-4 text-xl font-semibold">Quick Actions</h2>
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('admin.companies.create') }}" class="btn btn-outline flex items-center gap-2">
                    <span class="icon-[tabler--building-plus] size-5"></span>
                    Add Company
                </a>
                <a href="{{ route('admin.modules.create') }}" class="btn btn-outline flex items-center gap-2">
                    <span class="icon-[tabler--apps-add] size-5"></span>
                    Add Module
                </a>
                <a href="{{ route('admin.submodules.create') }}" class="btn btn-outline flex items-center gap-2">
                    <span class="icon-[tabler--component-plus] size-5"></span>
                    Add Submodule
                </a>
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-outline flex items-center gap-2">
                    <span class="icon-[tabler--key-plus] size-5"></span>
                    Add Permission
                </a>
            </div>
        </div>

        <!-- Recent Companies -->
        <div class="shadow-base-300/10 rounded-box bg-base-100 p-6 shadow-md">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base-content text-xl font-semibold">Recent Companies</h2>
                <a href="{{ route('admin.companies.index') }}" class="btn btn-text btn-sm">
                    View All
                    <span class="icon-[tabler--arrow-right] size-4"></span>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Modules</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (\App\Models\Company::with('modules')->latest()->take(5)->get() as $company)
                            <tr>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->email ?? 'N/A' }}</td>
                                <td>{{ $company->modules->count() }}</td>
                                <td>
                                    @if ($company->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-error">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.companies.show', $company) }}" class="btn btn-circle btn-text btn-sm" aria-label="View company">
                                        <span class="icon-[tabler--eye] size-5"></span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8">
                                    <p class="text-base-content/70">No companies found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
