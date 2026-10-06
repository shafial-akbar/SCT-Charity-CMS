@extends('admin.layouts.app')

@section('title', 'Gallery Photo')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Gallery Photo</h1>
            <p class="mt-1 text-sm text-gray-500">View photo details and bilingual metadata.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.gallery-photos.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">Back</a>
            @if(auth()->user()?->hasPermission('gallery_photos.update'))
                <a href="{{ route('admin.gallery-photos.edit', $galleryPhoto) }}" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Edit</a>
            @endif
        </div>
    </div>

    <section class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="grid gap-8 md:grid-cols-[320px_1fr]">
            <div>
                @if($galleryPhoto->media)
                    <img src="{{ asset('storage/' . ltrim($galleryPhoto->media->file_path, '/')) }}"
                         alt="{{ $galleryPhoto->alt_text_en ?? $galleryPhoto->caption_en ?? 'Gallery photo' }}"
                         class="w-full rounded-xl border border-gray-200 object-cover">
                @else
                    <div class="flex aspect-[4/3] items-center justify-center rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-400">No image</div>
                @endif
            </div>

            <div class="space-y-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Gallery</p>
                    <p class="mt-1 font-medium text-gray-900">{{ $galleryPhoto->gallery?->title_en ?? '—' }}</p>
                    <p class="text-sm text-gray-500">{{ $galleryPhoto->gallery?->title_bn ?? '' }}</p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Caption (English)</p>
                        <p class="mt-1 whitespace-pre-line text-sm text-gray-700">{{ $galleryPhoto->caption_en ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Caption (Bangla)</p>
                        <p class="mt-1 whitespace-pre-line text-sm text-gray-700">{{ $galleryPhoto->caption_bn ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Alt Text (English)</p>
                        <p class="mt-1 text-sm text-gray-700">{{ $galleryPhoto->alt_text_en ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Alt Text (Bangla)</p>
                        <p class="mt-1 text-sm text-gray-700">{{ $galleryPhoto->alt_text_bn ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Sort Order</p>
                        <p class="mt-1 text-sm text-gray-700">{{ $galleryPhoto->sort_order }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Media File</p>
                        <p class="mt-1 break-all text-sm text-gray-700">{{ $galleryPhoto->media?->original_name ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
