@extends('admin.layouts.app')

@section('title', 'Edit Program')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Program</h1>
        <p class="mt-1 text-sm text-gray-500">Update the bilingual program.</p>
    </div>

    <form
    method="POST"
    action="{{ route('admin.programs.update', $program) }}"
    enctype="multipart/form-data"
    >
        @method('PUT')
        @include('admin.programs._form', ['submitLabel' => 'Save Changes'])
    </form>
</div>
@endsection
