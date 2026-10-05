@extends('admin.layouts.app')
@section('title','Edit Page Section')
@section('content')
<div class="max-w-5xl space-y-6"><div><h1 class="text-2xl font-semibold">Edit Page Section</h1><p class="mt-1 text-sm text-gray-500">Page: {{ $page->title_en }}</p></div><div class="rounded-xl border border-gray-200 bg-white p-6"><form method="POST" action="{{ route('admin.pages.sections.update',[$page,$section]) }}">@method('PUT')@include('admin.page_sections._form')</form></div></div>
@endsection
