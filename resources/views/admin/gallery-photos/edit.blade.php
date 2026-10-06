@extends('admin.layouts.app')

@section('title', 'Edit Gallery Photo')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Gallery Photo</h1>
        <p class="mt-1 text-sm text-gray-500">Update the gallery photo and bilingual metadata.</p>
    </div>

    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">Please fix the highlighted fields and try again.</div>
    @endif

    <form method="POST" action="{{ route('admin.gallery-photos.update', $galleryPhoto) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.gallery-photos._form', ['submitLabel' => 'Save Changes'])
    </form>
</div>
@endsection
