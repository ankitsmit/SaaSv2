@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-base-content text-3xl font-bold">Edit Module</h1>
            <p class="text-base-content/70 mt-1">Update module information</p>
        </div>

        <div class="bg-base-100 shadow-base-300/20 w-full space-y-6 rounded-xl p-6 shadow-md lg:p-8">
            <form action="{{ route('admin.modules.update', $module) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="label-text" for="name">Module Name*</label>
                    <input type="text" name="name" placeholder="Enter module name" class="input @error('name') input-error @enderror" id="name" value="{{ old('name', $module->name) }}" required />
                    @error('name')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="slug">Slug*</label>
                    <input type="text" name="slug" placeholder="module-slug" class="input @error('slug') input-error @enderror" id="slug" value="{{ old('slug', $module->slug) }}" required />
                    @error('slug')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="icon">Icon</label>
                    <input type="text" name="icon" placeholder="dashboard, apps, etc." class="input @error('icon') input-error @enderror" id="icon" value="{{ old('icon', $module->icon) }}" />
                    @error('icon')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="description">Description</label>
                    <textarea name="description" placeholder="Enter module description" class="textarea @error('description') textarea-error @enderror" id="description" rows="3">{{ old('description', $module->description) }}</textarea>
                    @error('description')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="order">Order</label>
                    <input type="number" name="order" placeholder="0" class="input @error('order') input-error @enderror" id="order" value="{{ old('order', $module->order) }}" />
                    @error('order')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" class="checkbox" value="1" {{ old('is_active', $module->is_active) ? 'checked' : '' }} />
                    <label class="label-text" for="is_active">Active</label>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn btn-lg btn-primary btn-gradient">
                        Update Module
                    </button>

                    <a href="{{ route('admin.modules.index') }}" class="btn btn-lg btn-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
