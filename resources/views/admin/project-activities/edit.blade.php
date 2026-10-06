@extends('admin.layouts.app')

@section('title', 'Edit Project Activity')

@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Project Activity</h1>
        <p class="mt-1 text-sm text-gray-500">Update this project activity.</p>
    </div>

    <form method="POST" action="{{ route('admin.project-activities.update', $projectActivity) }}">
        @method('PUT')
        @include('admin.project-activities._form', ['submitLabel' => 'Save Changes'])
    </form>
</div>
@endsection
