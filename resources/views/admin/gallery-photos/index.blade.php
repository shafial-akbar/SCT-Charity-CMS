@extends('admin.layouts.app')

@section('title', 'Gallery Photos')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Gallery Photos</h1>
            <p class="mt-1 text-sm text-gray-500">Manage photos inside image galleries.</p>
        </div>

        @if(auth()->user()?->hasPermission('gallery_photos.create'))
            <a href="{{ route('admin.gallery-photos.create') }}"
               class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                Add Gallery Photo
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">Please fix the highlighted fields and try again.</div>
    @endif

    <form method="GET" class="flex flex-wrap gap-3 rounded-xl border border-gray-200 bg-white p-4">
        <input name="search" value="{{ request('search') }}"
               placeholder="Search caption, alt text or gallery..."
               class="min-w-[240px] flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">

        <select name="gallery_id"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
            <option value="">All Galleries</option>
            @foreach($galleries as $gallery)
                <option value="{{ $gallery->id }}" @selected(request('gallery_id') == $gallery->id)>
                    {{ $gallery->title_en }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Filter
        </button>
    </form>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        <th class="px-6 py-3">Photo</th>
                        <th class="px-6 py-3">Gallery</th>
                        <th class="px-6 py-3">Caption</th>
                        <th class="px-6 py-3">Order</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($photos as $photo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($photo->media)
                                        <img src="{{ asset('storage/' . ltrim($photo->media->file_path, '/')) }}"
                                             alt="{{ $photo->alt_text_en ?? $photo->caption_en ?? 'Gallery photo' }}"
                                             class="h-14 w-20 rounded-lg border border-gray-200 object-cover">
                                    @else
                                        <div class="h-14 w-20 rounded-lg border border-gray-200 bg-gray-50"></div>
                                    @endif
                                    <div class="text-sm text-gray-500">{{ $photo->media?->original_name ?? 'No media' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="font-medium text-gray-900">{{ $photo->gallery?->title_en ?? '—' }}</div>
                                <div class="text-sm text-gray-500">{{ $photo->gallery?->title_bn ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ \Illuminate\Support\Str::limit($photo->caption_en ?: $photo->caption_bn ?: '—', 90) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $photo->sort_order }}</td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                @if(auth()->user()?->hasPermission('gallery_photos.view'))
                                    <a href="{{ route('admin.gallery-photos.show', $photo) }}"
                                       class="inline-flex rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50">View</a>
                                @endif
                                @if(auth()->user()?->hasPermission('gallery_photos.update'))
                                    <a href="{{ route('admin.gallery-photos.edit', $photo) }}"
                                       class="ml-2 inline-flex rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50">Edit</a>
                                @endif
                                @if(auth()->user()?->hasPermission('gallery_photos.delete'))
                                    <form method="POST" action="{{ route('admin.gallery-photos.destroy', $photo) }}" class="ml-2 inline" onsubmit="return confirm('Delete this gallery photo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex rounded-lg border border-red-200 bg-white px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">No gallery photos found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-100 px-6 py-4">{{ $photos->links() }}</div>
    </div>
</div>
@endsection
