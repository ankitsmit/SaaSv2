@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-base-content text-3xl font-bold">Create Module</h1>
            <p class="text-base-content/70 mt-1">Add a new system module</p>
        </div>

        <div class="bg-base-100 shadow-base-300/20 w-full space-y-6 rounded-xl p-6 shadow-md lg:p-8">
            <form action="{{ route('admin.modules.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="label-text" for="name">Module Name*</label>
                    <input type="text" name="name" placeholder="Enter module name" class="input @error('name') input-error @enderror" id="name" value="{{ old('name') }}" required />
                    @error('name')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="slug">Slug</label>
                    <input type="text" name="slug" placeholder="module-slug (auto-generated if empty)" class="input @error('slug') input-error @enderror" id="slug" value="{{ old('slug') }}" />
                    @error('slug')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <p class="text-base-content/50 text-xs mt-1">Leave empty to auto-generate from name</p>
                </div>

                <div>
                    <label class="label-text" for="icon">Icon</label>
                    <input type="text" name="icon" placeholder="dashboard, apps, etc. (Tabler icon name)" class="input @error('icon') input-error @enderror" id="icon" value="{{ old('icon') }}" />
                    @error('icon')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <p class="text-base-content/50 text-xs mt-1">Tabler icon name without the "tabler--" prefix</p>
                </div>

                <div>
                    <label class="label-text" for="description">Description</label>
                    <textarea name="description" placeholder="Enter module description" class="textarea @error('description') textarea-error @enderror" id="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="order">Order</label>
                    <input type="number" name="order" placeholder="0" class="input @error('order') input-error @enderror" id="order" value="{{ old('order', 0) }}" />
                    @error('order')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" class="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} />
                    <label class="label-text" for="is_active">Active</label>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn btn-lg btn-primary btn-gradient">
                        Create Module
                    </button>

                    <a href="{{ route('admin.modules.index') }}" class="btn btn-lg btn-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
