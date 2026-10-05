@extends('admin.layouts.app')
@section('title', 'Pages')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div><h1 class="text-2xl font-semibold text-gray-900">Pages</h1><p class="mt-1 text-sm text-gray-500">Manage bilingual CMS pages.</p></div>
        @can('pages.create')
            <a href="{{ route('admin.pages.create') }}" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800">+ Create Page</a>
        @endcan
    </div>

    @if(session('success')) <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">{{ session('success') }}</div> @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50"><tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-3">Page</th><th class="px-6 py-3">Parent</th><th class="px-6 py-3">Status</th><th class="px-6 py-3 text-right">Actions</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($pages as $page)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4"><div class="font-medium text-gray-900">{{ $page->title_en }}</div><div class="text-sm text-gray-500">{{ $page->title_bn ?: '—' }} · /{{ $page->slug }}</div></td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $page->parent?->title_en ?: 'Root' }}</td>
                        <td class="px-6 py-4"><span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium">{{ ucfirst($page->status) }}</span></td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            @can('pages.update') <a class="mr-2 inline-flex rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium hover:bg-gray-50" href="{{ route('admin.pages.edit',$page) }}">Edit</a> @endcan
                            @can('pages.delete')
                            <form class="inline" method="POST" action="{{ route('admin.pages.destroy',$page) }}" onsubmit="return confirm('Delete this page and its sections?')">@csrf @method('DELETE')<button class="inline-flex rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700 hover:bg-red-100">Delete</button></form>
                            @endcan
                        </td>
                    </tr>
                @empty <tr><td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">No pages found.</td></tr> @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-100 px-6 py-4">{{ $pages->links() }}</div>
    </div>
</div>
@endsection
