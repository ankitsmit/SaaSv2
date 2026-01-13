@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-base-content text-3xl font-bold">Create Company</h1>
            <p class="text-base-content/70 mt-1">Add a new company or organization</p>
        </div>

        <div class="bg-base-100 shadow-base-300/20 w-full space-y-6 rounded-xl p-6 shadow-md lg:p-8">
            <form action="{{ route('admin.companies.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="label-text" for="name">Company Name*</label>
                    <input type="text" name="name" placeholder="Enter company name" class="input @error('name') input-error @enderror" id="name" value="{{ old('name') }}" required />
                    @error('name')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="slug">Slug</label>
                    <input type="text" name="slug" placeholder="company-slug (auto-generated if empty)" class="input @error('slug') input-error @enderror" id="slug" value="{{ old('slug') }}" />
                    @error('slug')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <p class="text-base-content/50 text-xs mt-1">Leave empty to auto-generate from name</p>
                </div>

                <div>
                    <label class="label-text" for="email">Email</label>
                    <input type="email" name="email" placeholder="Enter email address" class="input @error('email') input-error @enderror" id="email" value="{{ old('email') }}" />
                    @error('email')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="phone">Phone</label>
                    <input type="text" name="phone" placeholder="Enter phone number" class="input @error('phone') input-error @enderror" id="phone" value="{{ old('phone') }}" />
                    @error('phone')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label-text" for="address">Address</label>
                    <textarea name="address" placeholder="Enter address" class="textarea @error('address') textarea-error @enderror" id="address" rows="3">{{ old('address') }}</textarea>
                    @error('address')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" class="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} />
                    <label class="label-text" for="is_active">Active</label>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn btn-lg btn-primary btn-gradient">
                        Create Company
                    </button>

                    <a href="{{ route('admin.companies.index') }}" class="btn btn-lg btn-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
