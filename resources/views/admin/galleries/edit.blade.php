@extends('admin.layouts.app')
@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div><h1 class="text-2xl font-semibold text-slate-900">Edit Gallery</h1></div>
    <form method="POST" action="{{ route('admin.galleries.update',$gallery) }}" enctype="multipart/form-data" class="rounded-2xl border border-gray-200 bg-white p-6">
        @csrf @method('PUT')
        @include('admin.galleries._form',['gallery'=>$gallery])
        <div class="mt-6 flex justify-end gap-3 border-t border-gray-200 pt-5"><a href="{{ route('admin.galleries.show',$gallery) }}" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm">Cancel</a><button class="rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-medium text-white">Save Changes</button></div>
    </form>
</div>
@endsection
