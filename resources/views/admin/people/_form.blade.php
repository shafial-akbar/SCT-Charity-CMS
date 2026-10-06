@csrf

@php
    $statuses = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];
@endphp

<div class="space-y-6">
    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Basic Information</h2>
            <p class="mt-1 text-sm text-gray-500">Enter the person's name, bilingual designation and account status.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Name *</label>
                <input type="text" name="name" required
                       value="{{ old('name', $person->name ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Status *</label>
                <select name="status" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $person->status ?? 'active') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Designation (English)</label>
                <input type="text" name="designation_en"
                       value="{{ old('designation_en', $person->designation_en ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('designation_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Designation (Bangla)</label>
                <input type="text" name="designation_bn"
                       value="{{ old('designation_bn', $person->designation_bn ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('designation_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email"
                       value="{{ old('email', $person->email ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone"
                       value="{{ old('phone', $person->phone ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Sort Order</label>
                <input type="number" name="sort_order" min="0"
                       value="{{ old('sort_order', $person->sort_order ?? 0) }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </section>

    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Biography & Message</h2>
            <p class="mt-1 text-sm text-gray-500">Add bilingual biography and leadership/message content.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Biography (English)</label>
                <textarea name="biography_en" rows="7" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('biography_en', $person->biography_en ?? '') }}</textarea>
                @error('biography_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Biography (Bangla)</label>
                <textarea name="biography_bn" rows="7" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('biography_bn', $person->biography_bn ?? '') }}</textarea>
                @error('biography_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Message (English)</label>
                <textarea name="message_en" rows="9" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('message_en', $person->message_en ?? '') }}</textarea>
                @error('message_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Message (Bangla)</label>
                <textarea name="message_bn" rows="9" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('message_bn', $person->message_bn ?? '') }}</textarea>
                @error('message_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </section>

    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Photo / Media</h2>
            <p class="mt-1 text-sm text-gray-500">Select existing media or upload a new JPG, JPEG, PNG or WEBP image up to 5MB.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Select Existing Media</label>
                <select name="photo_id" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                    <option value="">No image</option>
                    @foreach($media as $item)
                        <option value="{{ $item->id }}" @selected(old('photo_id', $person->photo_id ?? '') == $item->id)>
                            {{ $item->original_name ?: $item->file_name }}
                        </option>
                    @endforeach
                </select>
                @error('photo_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Upload New Image</label>
                <input type="file" name="featured_image" accept="image/jpeg,image/png,image/webp"
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-gray-700">
                <p class="mt-1 text-xs text-gray-500">JPG, JPEG, PNG or WEBP. Maximum 5MB.</p>
                @error('featured_image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        @if(isset($person) && $person->photo)
            <div class="mt-6 border-t border-gray-100 pt-5">
                <p class="mb-2 text-sm font-medium text-gray-700">Current Image</p>
                <img src="{{ asset('storage/' . ltrim($person->photo->file_path, '/')) }}"
                     alt="{{ $person->photo->alt_text_en ?? $person->name }}"
                     class="h-40 w-40 rounded-lg border border-gray-200 object-cover">

                <label class="mt-4 flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="remove_featured_image" value="1"
                           class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-500">
                    Remove current image
                </label>
            </div>
        @endif
    </section>

    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Social Links</h2>
            <p class="mt-1 text-sm text-gray-500">Optional JSON object, for example: {"{"} "facebook": "https://facebook.com/example" {"}"}.</p>
        </div>

        <textarea name="social_links" rows="5"
                  placeholder='{"{"} "facebook": "https://facebook.com/example", "linkedin": "https://linkedin.com/in/example" {"}"}'
                  class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('social_links', isset($person) && is_array($person->social_links) ? json_encode($person->social_links, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '') }}</textarea>
        @error('social_links')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </section>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.people.index') }}"
           class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Cancel
        </a>
        <button type="submit"
                class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
            {{ $submitLabel ?? 'Save Person' }}
        </button>
    </div>
</div>
