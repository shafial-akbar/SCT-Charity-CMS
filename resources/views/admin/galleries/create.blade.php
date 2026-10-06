@extends('admin.layouts.app')
@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div><h1 class="text-2xl font-semibold text-slate-900">Create Gallery</h1><p class="mt-1 text-sm text-slate-500">Create a gallery before adding Gallery Photos.</p></div>
    <form method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data" class="rounded-2xl border border-gray-200 bg-white p-6">
        @csrf
        @include('admin.galleries._form')
        <div class="mt-6 flex justify-end gap-3 border-t border-gray-200 pt-5"><a href="{{ route('admin.galleries.index') }}" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm">Cancel</a><button class="rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-medium text-white">Create Gallery</button></div>
    </form>
</div>
@endsection
