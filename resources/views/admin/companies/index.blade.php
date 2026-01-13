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
                <h1 class="text-base-content text-3xl font-bold">Companies</h1>
                <p class="text-base-content/70 mt-1">Manage all companies and organizations</p>
            </div>
            <a href="{{ route('admin.companies.create') }}" class="btn btn-primary">
                <span class="icon-[tabler--plus] size-5"></span>
                Add Company
            </a>
        </div>

        <div class="rounded-box shadow-base-300/10 bg-base-100 w-full pb-2 shadow-md">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Modules</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($companies as $company)
                            <tr>
                                <td>{{ $company->name }}</td>
                                <td><code class="text-xs">{{ $company->slug }}</code></td>
                                <td>{{ $company->email ?? 'N/A' }}</td>
                                <td>{{ $company->phone ?? 'N/A' }}</td>
                                <td>{{ $company->modules->count() }}</td>
                                <td>
                                    @if ($company->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-error">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.companies.show', $company) }}" class="btn btn-circle btn-text btn-sm" aria-label="View company">
                                            <span class="icon-[tabler--eye] size-5"></span>
                                        </a>
                                        <a href="{{ route('admin.companies.edit', $company) }}" class="btn btn-circle btn-text btn-sm" aria-label="Edit company">
                                            <span class="icon-[tabler--pencil] size-5"></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8">
                                    <p class="text-base-content/70">No companies found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($companies->hasPages())
            <div class="mt-4">
                {{ $companies->links() }}
            </div>
        @endif
    </div>
@endsection
