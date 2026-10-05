@extends('admin.layouts.app')
@section('title','Edit Page Section')
@section('content')
<div class="mx-auto max-w-5xl space-y-6"><div><h1 class="text-2xl font-semibold text-gray-900">Edit Page Section</h1><p class="mt-1 text-sm text-gray-500">{{ $page->title_en }} · {{ $section->section_type }}</p></div><form method="POST" action="{{ route('admin.pages.sections.update',[$page,$section]) }}" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">@method('PUT') @include('admin.page-sections._form',['section'=>$section])</form></div>
@endsection
