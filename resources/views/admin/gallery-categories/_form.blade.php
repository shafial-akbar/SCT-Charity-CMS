@php $galleryCategory = $galleryCategory ?? null; @endphp
<div class="space-y-5">
    <div class="grid gap-5 md:grid-cols-2">
        <div><label class="mb-2 block text-sm font-medium text-slate-700">Name (English) *</label><input name="name_en" value="{{ old('name_en',$galleryCategory?->name_en) }}" required class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"></div>
        <div><label class="mb-2 block text-sm font-medium text-slate-700">Name (Bangla) *</label><input name="name_bn" value="{{ old('name_bn',$galleryCategory?->name_bn) }}" required class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"></div>
        <div><label class="mb-2 block text-sm font-medium text-slate-700">Slug (English) *</label><input name="slug_en" value="{{ old('slug_en',$galleryCategory?->slug_en) }}" required class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"></div>
        <div><label class="mb-2 block text-sm font-medium text-slate-700">Slug (Bangla) *</label><input name="slug_bn" value="{{ old('slug_bn',$galleryCategory?->slug_bn) }}" required class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"></div>
        <div><label class="mb-2 block text-sm font-medium text-slate-700">Sort Order *</label><input type="number" min="0" name="sort_order" value="{{ old('sort_order',$galleryCategory?->sort_order ?? 0) }}" required class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm"></div>
        <div><label class="mb-2 block text-sm font-medium text-slate-700">Status *</label><select name="status" required class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm"><option value="active" @selected(old('status',$galleryCategory?->status ?? 'active')==='active')>Active</option><option value="inactive" @selected(old('status',$galleryCategory?->status ?? 'active')==='inactive')>Inactive</option></select></div>
    </div>
    <div><label class="mb-2 block text-sm font-medium text-slate-700">Description (English)</label><textarea name="description_en" rows="4" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm">{{ old('description_en',$galleryCategory?->description_en) }}</textarea></div>
    <div><label class="mb-2 block text-sm font-medium text-slate-700">Description (Bangla)</label><textarea name="description_bn" rows="4" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm">{{ old('description_bn',$galleryCategory?->description_bn) }}</textarea></div>
</div>
