@php
    $gallery = $gallery ?? null;
@endphp

<div class="space-y-6">

    <div class="grid gap-5 md:grid-cols-2">

        {{-- Title English --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">
                Title (English) *
            </label>

            <input
                name="title_en"
                value="{{ old('title_en', $gallery?->title_en) }}"
                required
                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"
            >

            @error('title_en')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>


        {{-- Title Bangla --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">
                Title (Bangla) *
            </label>

            <input
                name="title_bn"
                value="{{ old('title_bn', $gallery?->title_bn) }}"
                required
                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"
            >

            @error('title_bn')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>


        {{-- Slug English --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">
                Slug (English) *
            </label>

            <input
                name="slug_en"
                value="{{ old('slug_en', $gallery?->slug_en) }}"
                required
                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"
            >

            @error('slug_en')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>


        {{-- Slug Bangla --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">
                Slug (Bangla) *
            </label>

            <input
                name="slug_bn"
                value="{{ old('slug_bn', $gallery?->slug_bn) }}"
                required
                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"
            >

            @error('slug_bn')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>


        {{-- Category --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">
                Category
            </label>

            <select
                name="category_id"
                class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm"
            >
                <option value="">No category</option>

                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected(
                            old('category_id', $gallery?->category_id) == $category->id
                        )
                    >
                        {{ $category->name_en }} / {{ $category->name_bn }}
                    </option>
                @endforeach
            </select>

            @error('category_id')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>


        {{-- Status --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">
                Status *
            </label>

            <select
                name="status"
                required
                class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm"
            >
                @foreach(['draft', 'published', 'archived'] as $status)
                    <option
                        value="{{ $status }}"
                        @selected(
                            old('status', $gallery?->status ?? 'draft') === $status
                        )
                    >
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            @error('status')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>


        {{-- Published At --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">
                Published At
            </label>

            <input
                type="datetime-local"
                name="published_at"
                value="{{ old('published_at', $gallery?->published_at?->format('Y-m-d\TH:i')) }}"
                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"
            >

            @error('published_at')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>


        {{-- Cover Image Upload --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">
                Cover Image
            </label>

            <input
                type="file"
                name="cover_image"
                accept="image/*"
                class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm"
            >

            @error('cover_image')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

    </div>


    {{-- Description English --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Description (English)
        </label>

        <textarea
            name="description_en"
            rows="5"
            class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"
        >{{ old('description_en', $gallery?->description_en) }}</textarea>

        @error('description_en')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>


    {{-- Description Bangla --}}
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">
            Description (Bangla)
        </label>

        <textarea
            name="description_bn"
            rows="5"
            class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"
        >{{ old('description_bn', $gallery?->description_bn) }}</textarea>

        @error('description_bn')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>


    {{-- Current Cover --}}
    @if($gallery?->coverImage)

        <div class="rounded-xl border border-gray-200 bg-slate-50 p-4">

            <div class="mb-3 text-sm font-medium text-slate-700">
                Current Cover
            </div>

            <img
                src="{{ asset('storage/' . ltrim($gallery->coverImage->file_path, '/')) }}"
                alt="{{ $gallery->title_en }}"
                class="h-40 w-64 rounded-lg object-cover"
            >

            {{-- IMPORTANT:
                 Do NOT put another form here.
                 Remove Cover form is handled separately in edit.blade.php.
            --}}

        </div>

    @endif

</div>