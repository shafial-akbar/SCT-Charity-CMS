@extends('admin.layouts.app')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div><h1 class="text-2xl font-semibold text-slate-900">Galleries</h1><p class="mt-1 text-sm text-slate-500">Manage photo galleries.</p></div>
        <a href="{{ route('admin.galleries.create') }}" class="rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-900">Create Gallery</a>
    </div>
    @if(session('success')) <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div> @endif
    <div class="rounded-2xl border border-gray-200 bg-white p-5">
        <form method="GET" class="grid gap-3 md:grid-cols-4">
            <input name="search" value="{{ request('search') }}" placeholder="Search galleries..." class="rounded-xl border border-gray-300 px-3 py-2.5 text-sm">
            <select name="category_id" class="rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm">
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name_en }}</option>
                @endforeach
            </select>
            <select name="status" class="rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm">
                <option value="">All statuses</option>
                @foreach(['draft','published','archived'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button class="rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-medium text-white">Filter</button>
        </form>
    </div>
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="border-b border-gray-200 bg-slate-50"><tr>
                    <th class="px-5 py-3 font-medium text-slate-600">Gallery</th>
                    <th class="px-5 py-3 font-medium text-slate-600">Category</th>
                    <th class="px-5 py-3 font-medium text-slate-600">Status</th>
                    <th class="px-5 py-3 font-medium text-slate-600">Photos</th>
                    <th class="px-5 py-3 text-right font-medium text-slate-600">Actions</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($galleries as $gallery)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4"><a href="{{ route('admin.galleries.show',$gallery) }}" class="font-medium text-slate-900 hover:underline">{{ $gallery->title_en }}</a><div class="text-xs text-slate-500">{{ $gallery->title_bn }}</div></td>
                        <td class="px-5 py-4 text-slate-600">{{ $gallery->category?->name_en ?? '—' }}</td>
                        <td class="px-5 py-4"><span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">{{ ucfirst($gallery->status) }}</span></td>
                        <td class="px-5 py-4 text-slate-600">{{ $gallery->photos_count }}</td>
                        <td class="px-5 py-4 text-right"><div class="flex justify-end gap-2">
                            <a href="{{ route('admin.galleries.show',$gallery) }}" class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-slate-700">View</a>
                            <a href="{{ route('admin.galleries.edit',$gallery) }}" class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-slate-700">Edit</a>
                            <form method="POST" action="{{ route('admin.galleries.destroy',$gallery) }}" onsubmit="return confirm('Delete this gallery?')">@csrf @method('DELETE')<button class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600">Delete</button></form>
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-slate-500">No galleries found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-200 px-5 py-4">{{ $galleries->links() }}</div>
    </div>
</div>
@endsection
