@extends('admin.layouts.app')
@section('title','Add Page Section')
@section('content')
<div class="mx-auto max-w-5xl space-y-6"><div><h1 class="text-2xl font-semibold text-gray-900">Add Page Section</h1><p class="mt-1 text-sm text-gray-500">Page: {{ $page->title_en }}</p></div><form method="POST" action="{{ route('admin.pages.sections.store',$page) }}" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">@include('admin.page-sections._form',['section'=>new \App\Models\PageSection])</form></div>
@endsection
