@csrf

<div class="space-y-6">
    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Gallery & Image</h2>
            <p class="mt-1 text-sm text-gray-500">Choose the gallery and either select existing media or upload a new image.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Gallery <span class="text-red-500">*</span></label>
                <select name="gallery_id" required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                    <option value="">Select gallery</option>
                    @foreach($galleries as $gallery)
                        <option value="{{ $gallery->id }}" @selected(old('gallery_id', $galleryPhoto->gallery_id ?? '') == $gallery->id)>
                            {{ $gallery->title_en }}{{ $gallery->title_bn ? ' — ' . $gallery->title_bn : '' }}
                        </option>
                    @endforeach
                </select>
                @error('gallery_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Select Existing Media</label>
                <select name="media_id"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                    <option value="">No existing media</option>
                    @foreach($media as $item)
                        <option value="{{ $item->id }}" @selected(old('media_id', $galleryPhoto->media_id ?? '') == $item->id)>
                            {{ $item->original_name ?: $item->file_name }}
                        </option>
                    @endforeach
                </select>
                @error('media_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-medium text-gray-700">Upload New Image</label>
                <input type="file" name="photo" accept="image/jpeg,image/png,image/webp"
                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-gray-700">
                <p class="mt-1 text-xs text-gray-500">JPG, JPEG, PNG or WEBP. Maximum 5MB. Uploading a new image replaces the selected/current media.</p>
                @error('photo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        @if(isset($galleryPhoto) && $galleryPhoto->media)
            <div class="mt-6 border-t border-gray-100 pt-5">
                <p class="mb-2 text-sm font-medium text-gray-700">Current Image</p>
                <img src="{{ asset('storage/' . ltrim($galleryPhoto->media->file_path, '/')) }}"
                     alt="{{ $galleryPhoto->alt_text_en ?? $galleryPhoto->caption_en ?? 'Gallery photo' }}"
                     class="h-48 w-72 rounded-lg border border-gray-200 object-cover">

                <label class="mt-4 flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="remove_photo" value="1"
                           class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-500">
                    Remove current image
                </label>
            </div>
        @endif
    </section>

    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Bilingual Content</h2>
            <p class="mt-1 text-sm text-gray-500">Add captions and alternative text in English and Bangla.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Caption (English)</label>
                <textarea name="caption_en" rows="5"
                          class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('caption_en', $galleryPhoto->caption_en ?? '') }}</textarea>
                @error('caption_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Caption (Bangla)</label>
                <textarea name="caption_bn" rows="5"
                          class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">{{ old('caption_bn', $galleryPhoto->caption_bn ?? '') }}</textarea>
                @error('caption_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Alt Text (English)</label>
                <input type="text" name="alt_text_en" value="{{ old('alt_text_en', $galleryPhoto->alt_text_en ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('alt_text_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Alt Text (Bangla)</label>
                <input type="text" name="alt_text_bn" value="{{ old('alt_text_bn', $galleryPhoto->alt_text_bn ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('alt_text_bn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Sort Order</label>
                <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $galleryPhoto->sort_order ?? 0) }}"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </section>

    <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-5">
        <a href="{{ route('admin.gallery-photos.index') }}"
           class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
        <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
            {{ $submitLabel }}
        </button>
    </div>
</div>
