@csrf

<div class="space-y-6">
    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Title (English) *</label>
            <input type="text" name="title_en" value="{{ old('title_en', $program->title_en ?? '') }}" required
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
            @error('title_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Title (Bangla) *</label>
            <input type="text" name="title_bn" value="{{ old('title_bn', $program->title_bn ?? '') }}" required
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
            @error('title_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Slug (English)</label>
            <input type="text" name="slug_en" value="{{ old('slug_en', $program->slug_en ?? '') }}"
                   placeholder="auto-generated if empty"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
            @error('slug_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Slug (Bangla)</label>
            <input type="text" name="slug_bn" value="{{ old('slug_bn', $program->slug_bn ?? '') }}"
                   placeholder="optional"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
            @error('slug_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Short Description (English)</label>
            <textarea name="short_description_en" rows="4"
                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('short_description_en', $program->short_description_en ?? '') }}</textarea>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Short Description (Bangla)</label>
            <textarea name="short_description_bn" rows="4"
                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('short_description_bn', $program->short_description_bn ?? '') }}</textarea>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Description (English)</label>
            <textarea name="description_en" rows="8"
                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('description_en', $program->description_en ?? '') }}</textarea>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Description (Bangla)</label>
            <textarea name="description_bn" rows="8"
                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('description_bn', $program->description_bn ?? '') }}</textarea>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Featured Image</label>
            <select name="featured_image_id"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                <option value="">No image</option>
                @foreach($media as $item)
                    <option value="{{ $item->id }}" @selected(old('featured_image_id', $program->featured_image_id ?? '') === $item->id)>
                        {{ $item->original_name ?: $item->file_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Status *</label>
            <select name="status" required
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @foreach(['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $program->status ?? 'draft') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Sort Order</label>
            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $program->sort_order ?? 0) }}"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">SEO Title (English)</label>
            <input type="text" name="seo_title_en" value="{{ old('seo_title_en', $program->seo_title_en ?? '') }}"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">SEO Title (Bangla)</label>
            <input type="text" name="seo_title_bn" value="{{ old('seo_title_bn', $program->seo_title_bn ?? '') }}"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">SEO Description (English)</label>
            <textarea name="seo_description_en" rows="4"
                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('seo_description_en', $program->seo_description_en ?? '') }}</textarea>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">SEO Description (Bangla)</label>
            <textarea name="seo_description_bn" rows="4"
                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('seo_description_bn', $program->seo_description_bn ?? '') }}</textarea>
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Published At</label>
        <input type="datetime-local" name="published_at"
               value="{{ old('published_at', isset($program) && $program->published_at ? $program->published_at->format('Y-m-d\TH:i') : '') }}"
               class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
    </div>

    <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-5">
        <a href="{{ route('admin.programs.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
        <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">{{ $submitLabel }}</button>
    </div>
</div>
