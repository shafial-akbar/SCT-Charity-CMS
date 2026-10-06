@csrf

<div class="space-y-6">

    {{-- Basic Information --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Basic Information</h2>
            <p class="mt-1 text-sm text-gray-500">
                Enter the program's bilingual title and URL slugs.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">

            {{-- Title English --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Title (English) <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="title_en"
                    value="{{ old('title_en', $program->title_en ?? '') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >

                @error('title_en')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Title Bangla --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Title (Bangla) <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="title_bn"
                    value="{{ old('title_bn', $program->title_bn ?? '') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >

                @error('title_bn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug English --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Slug (English)
                </label>

                <input
                    type="text"
                    name="slug_en"
                    value="{{ old('slug_en', $program->slug_en ?? '') }}"
                    placeholder="auto-generated if empty"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >

                @error('slug_en')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug Bangla --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Slug (Bangla)
                </label>

                <input
                    type="text"
                    name="slug_bn"
                    value="{{ old('slug_bn', $program->slug_bn ?? '') }}"
                    placeholder="auto-generated if empty"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >

                @error('slug_bn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>


    {{-- Description --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Program Content</h2>
            <p class="mt-1 text-sm text-gray-500">
                Add short and detailed descriptions in both languages.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">

            {{-- Short Description English --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Short Description (English)
                </label>

                <textarea
                    name="short_description_en"
                    rows="4"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >{{ old('short_description_en', $program->short_description_en ?? '') }}</textarea>

                @error('short_description_en')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Short Description Bangla --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Short Description (Bangla)
                </label>

                <textarea
                    name="short_description_bn"
                    rows="4"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >{{ old('short_description_bn', $program->short_description_bn ?? '') }}</textarea>

                @error('short_description_bn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description English --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Description (English)
                </label>

                <textarea
                    name="description_en"
                    rows="8"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >{{ old('description_en', $program->description_en ?? '') }}</textarea>

                @error('description_en')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description Bangla --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Description (Bangla)
                </label>

                <textarea
                    name="description_bn"
                    rows="8"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >{{ old('description_bn', $program->description_bn ?? '') }}</textarea>

                @error('description_bn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>


    {{-- Media & Publishing --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Media & Publishing</h2>
            <p class="mt-1 text-sm text-gray-500">
                Choose an existing image or upload a new featured image.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-3">

            {{-- Existing Media --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Existing Featured Image
                </label>

                <select
                    name="featured_image_id"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >
                    <option value="">No image</option>

                    @foreach($media as $item)
                        <option
                            value="{{ $item->id }}"
                            @selected(old('featured_image_id', $program->featured_image_id ?? '') == $item->id)
                        >
                            {{ $item->original_name ?: $item->file_name }}
                        </option>
                    @endforeach
                </select>

                @error('featured_image_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Upload New Image --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Upload New Featured Image
                </label>

                <input
                    type="file"
                    name="featured_image"
                    accept="image/jpeg,image/png,image/webp"
                    class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-2 file:text-sm file:font-medium hover:file:bg-gray-200 focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >

                <p class="mt-1 text-xs text-gray-500">
                    JPG, JPEG, PNG or WebP. Maximum 5MB.
                </p>

                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>

                <select
                    name="status"
                    required
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >
                    @foreach([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived'
                    ] as $value => $label)

                        <option
                            value="{{ $value }}"
                            @selected(old('status', $program->status ?? 'draft') === $value)
                        >
                            {{ $label }}
                        </option>

                    @endforeach
                </select>

                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Sort Order --}}
        <div class="mt-6 max-w-sm">
            <label class="mb-2 block text-sm font-medium text-gray-700">
                Sort Order
            </label>

            <input
                type="number"
                name="sort_order"
                min="0"
                value="{{ old('sort_order', $program->sort_order ?? 0) }}"
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
            >

            @error('sort_order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Current Image Preview --}}
        @if(isset($program) && $program->featuredImage)
            <div class="mt-6 border-t border-gray-200 pt-6">
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Current Featured Image
                </label>

                <div class="flex items-start gap-4">
                    <img
                        src="{{ asset('storage/' . ltrim($program->featuredImage->file_path, '/')) }}"
                        alt="{{ $program->featuredImage->alt_text_en ?? $program->title_en }}"
                        class="h-32 w-48 rounded-lg border border-gray-200 object-cover"
                    >

                    <div class="text-sm text-gray-600">
                        <p class="font-medium text-gray-900">
                            {{ $program->featuredImage->original_name ?: $program->featuredImage->file_name }}
                        </p>

                        <p class="mt-1">
                            Uploading a new image will replace this image as the featured image.
                        </p>
                    </div>
                </div>
            </div>
        @endif

    </div>


    {{-- SEO --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">SEO</h2>
            <p class="mt-1 text-sm text-gray-500">
                Optional search-engine metadata for both languages.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">

            {{-- SEO Title English --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    SEO Title (English)
                </label>

                <input
                    type="text"
                    name="seo_title_en"
                    value="{{ old('seo_title_en', $program->seo_title_en ?? '') }}"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >

                @error('seo_title_en')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- SEO Title Bangla --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    SEO Title (Bangla)
                </label>

                <input
                    type="text"
                    name="seo_title_bn"
                    value="{{ old('seo_title_bn', $program->seo_title_bn ?? '') }}"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >

                @error('seo_title_bn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- SEO Description English --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    SEO Description (English)
                </label>

                <textarea
                    name="seo_description_en"
                    rows="4"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >{{ old('seo_description_en', $program->seo_description_en ?? '') }}</textarea>

                @error('seo_description_en')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- SEO Description Bangla --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    SEO Description (Bangla)
                </label>

                <textarea
                    name="seo_description_bn"
                    rows="4"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                >{{ old('seo_description_bn', $program->seo_description_bn ?? '') }}</textarea>

                @error('seo_description_bn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>


    {{-- Publishing Date --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6">
        <label class="mb-2 block text-sm font-medium text-gray-700">
            Published At
        </label>

        <input
            type="datetime-local"
            name="published_at"
            value="{{ old('published_at', isset($program) && $program->published_at ? $program->published_at->format('Y-m-d\TH:i') : '') }}"
            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
        >

        @error('published_at')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>


    {{-- Actions --}}
    <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-5">

        <a
            href="{{ route('admin.programs.index') }}"
            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800"
        >
            {{ $submitLabel }}
        </button>

    </div>

</div>