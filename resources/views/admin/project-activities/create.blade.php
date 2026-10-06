@extends('admin.layouts.app')

@section('title', 'Create Project Activity')

@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Create Project Activity</h1>
        <p class="mt-1 text-sm text-gray-500">Add an activity to an existing project.</p>
    </div>

    <form method="POST" action="{{ route('admin.project-activities.store') }}">
        @include('admin.project-activities._form', ['submitLabel' => 'Create Activity'])
    </form>
</div>
@endsection
