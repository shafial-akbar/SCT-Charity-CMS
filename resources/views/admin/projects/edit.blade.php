@extends('admin.layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Project</h1>
        <p class="mt-1 text-sm text-gray-500">Update the project information.</p>
    </div>

    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            Please fix the highlighted fields and try again.
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.projects.update', $project) }}"
          enctype="multipart/form-data">
        @method('PUT')
        @include('admin.projects._form', ['submitLabel' => 'Save Changes'])
    </form>
</div>
@endsection
