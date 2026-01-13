@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-base-content text-3xl font-bold">Edit Permission</h1>
            <p class="text-base-content/70 mt-1">Update permission information</p>
        </div>

        <div class="bg-base-100 shadow-base-300/20 w-full space-y-6 rounded-xl p-6 shadow-md lg:p-8">
            <form action="{{ route('admin.permissions.update', $permission) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="label-text" for="name">Permission Name*</label>
                    <input type="text" name="name" placeholder="Enter permission name" class="input @error('name') input-error @enderror" id="name" value="{{ old('name', $permission->name) }}" required />
                    @error('name')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="slug">Slug*</label>
                    <input type="text" name="slug" placeholder="permission-slug" class="input @error('slug') input-error @enderror" id="slug" value="{{ old('slug', $permission->slug) }}" required />
                    @error('slug')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="type">Type*</label>
                    <select name="type" id="type" class="select @error('type') select-error @enderror" required onchange="togglePermissionTargets()">
                        <option value="">Select type</option>
                        <option value="module" {{ old('type', $permission->type) == 'module' ? 'selected' : '' }}>Module</option>
                        <option value="submodule" {{ old('type', $permission->type) == 'submodule' ? 'selected' : '' }}>Submodule</option>
                    </select>
                    @error('type')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div id="module-field">
                    <label class="label-text" for="module_id">Module</label>
                    <select name="module_id" id="module_id" class="select @error('module_id') select-error @enderror">
                        <option value="">Select a module</option>
                        @foreach ($modules as $module)
                            <option value="{{ $module->id }}" {{ old('module_id', $permission->module_id) == $module->id ? 'selected' : '' }}>{{ $module->name }}</option>
                        @endforeach
                    </select>
                    @error('module_id')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div id="submodule-field">
                    <label class="label-text" for="submodule_id">Submodule</label>
                    <select name="submodule_id" id="submodule_id" class="select @error('submodule_id') select-error @enderror">
                        <option value="">Select a submodule</option>
                        @foreach ($modules as $module)
                            @foreach ($module->submodules as $submodule)
                                <option value="{{ $submodule->id }}" data-module="{{ $module->id }}" {{ old('submodule_id', $permission->submodule_id) == $submodule->id ? 'selected' : '' }}>{{ $module->name }} - {{ $submodule->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('submodule_id')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="description">Description</label>
                    <textarea name="description" placeholder="Enter permission description" class="textarea @error('description') textarea-error @enderror" id="description" rows="3">{{ old('description', $permission->description) }}</textarea>
                    @error('description')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn btn-lg btn-primary btn-gradient">
                        Update Permission
                    </button>

                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-lg btn-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePermissionTargets() {
            const type = document.getElementById('type').value;
            const moduleField = document.getElementById('module-field');
            const submoduleField = document.getElementById('submodule-field');
            
            if (type === 'module') {
                moduleField.style.display = 'block';
                submoduleField.style.display = 'none';
                document.getElementById('submodule_id').value = '';
            } else if (type === 'submodule') {
                moduleField.style.display = 'none';
                submoduleField.style.display = 'block';
                document.getElementById('module_id').value = '';
            } else {
                moduleField.style.display = 'block';
                submoduleField.style.display = 'block';
            }
        }
        
        // Initialize on page load
        togglePermissionTargets();
    </script>
    @endpush
@endsection
