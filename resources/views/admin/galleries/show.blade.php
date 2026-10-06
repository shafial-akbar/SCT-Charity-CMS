@extends('admin.layouts.app')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div><h1 class="text-2xl font-semibold text-slate-900">{{ $gallery->title_en }}</h1><p class="mt-1 text-sm text-slate-500">{{ $gallery->title_bn }}</p></div>
        <div class="flex gap-2"><a href="{{ route('admin.galleries.edit',$gallery) }}" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm">Edit</a><a href="{{ route('admin.gallery-photos.create',['gallery_id'=>$gallery->id]) }}" class="rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-medium text-white">Add Photo</a></div>
    </div>
    @if(session('success'))<div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>@endif
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6">
            <dl class="grid gap-5 sm:grid-cols-2">
                <div><dt class="text-xs font-medium uppercase text-slate-500">Title (English)</dt><dd class="mt-1 text-sm">{{ $gallery->title_en }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-slate-500">Title (Bangla)</dt><dd class="mt-1 text-sm">{{ $gallery->title_bn }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-slate-500">Slug (English)</dt><dd class="mt-1 text-sm">{{ $gallery->slug_en }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-slate-500">Slug (Bangla)</dt><dd class="mt-1 text-sm">{{ $gallery->slug_bn }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-slate-500">Category</dt><dd class="mt-1 text-sm">{{ $gallery->category?->name_en ?? '—' }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-slate-500">Status</dt><dd class="mt-1 text-sm">{{ ucfirst($gallery->status) }}</dd></div>
            </dl>
            <div class="mt-6 grid gap-5 md:grid-cols-2">
                <div><h2 class="text-sm font-semibold">Description (English)</h2><p class="mt-2 whitespace-pre-line text-sm text-slate-600">{{ $gallery->description_en ?: '—' }}</p></div>
                <div><h2 class="text-sm font-semibold">Description (Bangla)</h2><p class="mt-2 whitespace-pre-line text-sm text-slate-600">{{ $gallery->description_bn ?: '—' }}</p></div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6"><h2 class="text-sm font-semibold">Cover Image</h2>
        @if($gallery->coverImage)

<img src="{{ asset('storage/' . ltrim($gallery->coverImage->file_path, '/')) }}"
                                             alt="{{ $gallery->title_en }}"
                                             class="mt-3 aspect-[4/3] w-full rounded-xl object-cover">

        <!-- <img src="{{ Storage::disk($gallery->coverImage->disk)->url($gallery->coverImage->file_path) }}" alt="{{ $gallery->title_en }}" class="mt-3 aspect-[4/3] w-full rounded-xl object-cover"> -->
        @else
        <div class="mt-3 flex aspect-[4/3] items-center justify-center rounded-xl bg-slate-50 text-sm text-slate-500">No cover image</div>@endif</div>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Photos ({{ $gallery->photos->count() }})</h2><a href="{{ route('admin.gallery-photos.create',['gallery_id'=>$gallery->id]) }}" class="rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-medium text-white">Add Photo</a></div>
        @if($gallery->photos->isNotEmpty())
            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($gallery->photos as $photo)
                    <a href="{{ route('admin.gallery-photos.show',$photo) }}" class="group rounded-xl border border-gray-200 p-2 hover:bg-slate-50">
                        @if($photo->media)

<img src="{{ asset('storage/' . ltrim($photo->media->file_path, '/')) }}"
                                             alt="{{ $photo->alt_text_en ?: $gallery->title_en }}"
                                             class="aspect-square w-full rounded-lg object-cover">

                        <!-- <img src="{{ Storage::disk($photo->media->disk)->url($photo->media->file_path) }}" alt="{{ $photo->alt_text_en ?: $gallery->title_en }}" class="aspect-square w-full rounded-lg object-cover"> -->
                        @endif
                        <div class="mt-2 truncate text-xs font-medium text-slate-700">{{ $photo->caption_en ?: 'Photo' }}</div>
                    </a>
                @endforeach
            </div>
        @else <p class="mt-5 text-sm text-slate-500">No photos in this gallery yet.</p> @endif
    </div>
</div>
@endsection
