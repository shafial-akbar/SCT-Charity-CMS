@extends('admin.layouts.app')
@section('title','Create Page')
@section('content')
<div class="max-w-5xl space-y-6"><div><h1 class="text-2xl font-semibold">Create Page</h1><p class="mt-1 text-sm text-gray-500">Create a bilingual page.</p></div>
<div class="rounded-xl border border-gray-200 bg-white p-6"><form method="POST" action="{{ route('admin.pages.store') }}">@include('admin.pages._form',['page'=>null])</form></div></div>
@endsection
