@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-base-content text-3xl font-bold">Create Submodule</h1>
            <p class="text-base-content/70 mt-1">Add a new submodule</p>
        </div>

        <div class="bg-base-100 shadow-base-300/20 w-full space-y-6 rounded-xl p-6 shadow-md lg:p-8">
            <form action="{{ route('admin.submodules.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="label-text" for="module_id">Module*</label>
                    <select name="module_id" id="module_id" class="select @error('module_id') select-error @enderror" required>
                        <option value="">Select a module</option>
                        @foreach ($modules as $module)
                            <option value="{{ $module->id }}" {{ old('module_id', request('module_id')) == $module->id ? 'selected' : '' }}>{{ $module->name }}</option>
                        @endforeach
                    </select>
                    @error('module_id')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="name">Submodule Name*</label>
                    <input type="text" name="name" placeholder="Enter submodule name" class="input @error('name') input-error @enderror" id="name" value="{{ old('name') }}" required />
                    @error('name')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="slug">Slug</label>
                    <input type="text" name="slug" placeholder="submodule-slug (auto-generated if empty)" class="input @error('slug') input-error @enderror" id="slug" value="{{ old('slug') }}" />
                    @error('slug')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <p class="text-base-content/50 text-xs mt-1">Leave empty to auto-generate from name</p>
                </div>

                <div>
                    <label class="label-text" for="route">Route Name</label>
                    <input type="text" name="route" placeholder="client.example" class="input @error('route') input-error @enderror" id="route" value="{{ old('route') }}" />
                    @error('route')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <p class="text-base-content/50 text-xs mt-1">Laravel route name for this submodule</p>
                </div>

                <div>
                    <label class="label-text" for="icon">Icon</label>
                    <input type="text" name="icon" placeholder="dashboard, apps, etc." class="input @error('icon') input-error @enderror" id="icon" value="{{ old('icon') }}" />
                    @error('icon')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="description">Description</label>
                    <textarea name="description" placeholder="Enter submodule description" class="textarea @error('description') textarea-error @enderror" id="description" rows="3">{{ old('description') }}</textarea>
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
                        Create Submodule
                    </button>

                    <a href="{{ route('admin.submodules.index') }}" class="btn btn-lg btn-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
