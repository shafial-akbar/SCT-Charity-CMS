@extends('admin.layouts.app')

@section('title', 'Create Program')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Create Program</h1>
        <p class="mt-1 text-sm text-gray-500">Create a bilingual program.</p>
    </div>

    <form method="POST" action="{{ route('admin.programs.store') }}" class="rounded-xl border border-gray-200 bg-white p-6">
        @include('admin.programs._form', ['submitLabel' => 'Create Program'])
    </form>
</div>
@endsection
