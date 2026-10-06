@csrf

@php
    $statuses = [
        'draft' => 'Draft',
        'planned' => 'Planned',
        'active' => 'Active',
        'completed' => 'Completed',
        'archived' => 'Archived',
    ];
@endphp

<div class="space-y-6">
    {{-- Basic Information --}}
    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Basic Information</h2>
            <p class="mt-1 text-sm text-gray-500">Enter the project's bilingual title, program and URL slugs.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Program</label>
                <select name="program_id"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                    <option value="">No program</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" @selected(old('program_id', $project->program_id ?? '') == $program->id)>
                            {{ $program->title_en }}{{ $program->title_bn ? ' / ' . $program->title_bn : '' }}
                        </option>
                    @endforeach
                </select>
                @error('program_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Status *</label>
                <select name="status" required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $project->status ?? 'draft') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Title (English) *</label>
                <input type="text" name="title_en" required
                       value="{{ old('title_en', $project->title_en ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('title_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Title (Bangla) *</label>
                <input type="text" name="title_bn" required
                       value="{{ old('title_bn', $project->title_bn ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('title_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Slug (English)</label>
                <input type="text" name="slug_en"
                       value="{{ old('slug_en', $project->slug_en ?? '') }}"
                       placeholder="auto-generated if empty"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('slug_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Slug (Bangla)</label>
                <input type="text" name="slug_bn"
                       value="{{ old('slug_bn', $project->slug_bn ?? '') }}"
                       placeholder="auto-generated if empty"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('slug_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </section>

    {{-- Location & Dates --}}
    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Location & Dates</h2>
            <p class="mt-1 text-sm text-gray-500">Add where the project operates and its planned timeline.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Location (English)</label>
                <input type="text" name="location_en"
                       value="{{ old('location_en', $project->location_en ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('location_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Location (Bangla)</label>
                <input type="text" name="location_bn"
                       value="{{ old('location_bn', $project->location_bn ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('location_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date"
                       value="{{ old('start_date', isset($project) && $project->start_date ? $project->start_date->format('Y-m-d') : '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('start_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" name="end_date"
                       value="{{ old('end_date', isset($project) && $project->end_date ? $project->end_date->format('Y-m-d') : '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('end_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </section>

    {{-- Project Content --}}
    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Project Content</h2>
            <p class="mt-1 text-sm text-gray-500">Add short and detailed descriptions in both languages.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Short Description (English)</label>
                <textarea name="short_description_en" rows="4"
                          class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('short_description_en', $project->short_description_en ?? '') }}</textarea>
                @error('short_description_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Short Description (Bangla)</label>
                <textarea name="short_description_bn" rows="4"
                          class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('short_description_bn', $project->short_description_bn ?? '') }}</textarea>
                @error('short_description_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Description (English)</label>
                <textarea name="description_en" rows="8"
                          class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('description_en', $project->description_en ?? '') }}</textarea>
                @error('description_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Description (Bangla)</label>
                <textarea name="description_bn" rows="8"
                          class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('description_bn', $project->description_bn ?? '') }}</textarea>
                @error('description_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </section>

    {{-- Featured Image / Media --}}
    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Featured Image / Media</h2>
            <p class="mt-1 text-sm text-gray-500">Select an existing media item or upload a new project image.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Select Existing Media</label>
                <select name="featured_image_id"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                    <option value="">No image</option>
                    @foreach($media as $item)
                        <option value="{{ $item->id }}" @selected(old('featured_image_id', $project->featured_image_id ?? '') == $item->id)>
                            {{ $item->original_name ?: $item->file_name }}
                        </option>
                    @endforeach
                </select>
                @error('featured_image_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Upload New Image</label>
                <input type="file" name="featured_image" accept="image/jpeg,image/png,image/webp"
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-gray-700">
                <p class="mt-1 text-xs text-gray-500">JPG, JPEG, PNG or WEBP. Maximum 5MB.</p>
                @error('featured_image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        @if(isset($project) && $project->featuredImage)
            <div class="mt-6 border-t border-gray-100 pt-5">
                <p class="mb-2 text-sm font-medium text-gray-700">Current Image</p>
                <img src="{{ asset('storage/' . ltrim($project->featuredImage->file_path, '/')) }}"
                     alt="{{ $project->featuredImage->alt_text_en ?? $project->title_en }}"
                     class="h-40 w-64 rounded-lg border border-gray-200 object-cover">

                <label class="mt-4 flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="remove_featured_image" value="1"
                           class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-500">
                    Remove current featured image
                </label>
            </div>
        @endif
    </section>

    {{-- SEO --}}
    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">SEO & Publishing</h2>
            <p class="mt-1 text-sm text-gray-500">Add search-engine metadata and the publication date.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">SEO Title (English)</label>
                <input type="text" name="seo_title_en"
                       value="{{ old('seo_title_en', $project->seo_title_en ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('seo_title_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">SEO Title (Bangla)</label>
                <input type="text" name="seo_title_bn"
                       value="{{ old('seo_title_bn', $project->seo_title_bn ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('seo_title_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">SEO Description (English)</label>
                <textarea name="seo_description_en" rows="4"
                          class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('seo_description_en', $project->seo_description_en ?? '') }}</textarea>
                @error('seo_description_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">SEO Description (Bangla)</label>
                <textarea name="seo_description_bn" rows="4"
                          class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('seo_description_bn', $project->seo_description_bn ?? '') }}</textarea>
                @error('seo_description_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Published At</label>
                <input type="datetime-local" name="published_at"
                       value="{{ old('published_at', isset($project) && $project->published_at ? $project->published_at->format('Y-m-d\\TH:i') : '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('published_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </section>

    <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-5">
        <a href="{{ route('admin.projects.index') }}"
           class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Cancel
        </a>
        <button type="submit"
                class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
            {{ $submitLabel }}
        </button>
    </div>
</div>
