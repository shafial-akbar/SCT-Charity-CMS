@extends('admin.layouts.app')
@section('title','Edit Page')
@section('content')
<div class="max-w-5xl space-y-6">
<div class="flex items-center justify-between"><div><h1 class="text-2xl font-semibold">Edit Page</h1><p class="mt-1 text-sm text-gray-500">{{ $page->title_en }}</p></div>
@can('pages.sections.create') <a href="{{ route('admin.pages.sections.create',$page) }}" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white">+ Add Section</a>@endcan</div>
@if(session('success'))<div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">{{ session('success') }}</div>@endif
<div class="rounded-xl border border-gray-200 bg-white p-6"><form method="POST" action="{{ route('admin.pages.update',$page) }}">@method('PUT')@include('admin.pages._form')</form></div>
<div class="rounded-xl border border-gray-200 bg-white">
<div class="border-b px-6 py-4"><h2 class="font-semibold">Page Sections</h2></div>
<div class="divide-y">@forelse($page->sections as $section)<div class="flex items-center justify-between gap-4 px-6 py-4"><div><div class="font-medium">{{ $section->title_en ?: $section->section_type }}</div><div class="text-sm text-gray-500">{{ $section->section_type }} · {{ ucfirst($section->status) }}</div></div><div>@can('pages.sections.update')<a href="{{ route('admin.pages.sections.edit',[$page,$section]) }}" class="mr-2 inline-flex rounded-lg border border-gray-300 px-3 py-1.5 text-sm">Edit</a>@endcan @can('pages.sections.delete')<form class="inline" method="POST" action="{{ route('admin.pages.sections.destroy',[$page,$section]) }}" onsubmit="return confirm('Delete this section?')">@csrf @method('DELETE')<button class="inline-flex rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-sm text-red-700">Delete</button></form>@endcan</div></div>@empty<div class="px-6 py-8 text-sm text-gray-500">No sections yet.</div>@endforelse</div></div>
</div>
@endsection
