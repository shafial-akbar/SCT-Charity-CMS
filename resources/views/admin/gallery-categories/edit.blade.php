@extends('admin.layouts.app')
@section('content')
<div class="mx-auto max-w-4xl space-y-6"><div><h1 class="text-2xl font-semibold text-slate-900">Edit Gallery Category</h1></div><form method="POST" action="{{ route('admin.gallery-categories.update',$galleryCategory) }}" class="rounded-2xl border border-gray-200 bg-white p-6">@csrf @method('PUT') @include('admin.gallery-categories._form',['galleryCategory'=>$galleryCategory])<div class="mt-6 flex justify-end gap-3 border-t border-gray-200 pt-5"><a href="{{ route('admin.gallery-categories.index') }}" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm">Cancel</a><button class="rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-medium text-white">Save Changes</button></div></form></div>
@endsection
