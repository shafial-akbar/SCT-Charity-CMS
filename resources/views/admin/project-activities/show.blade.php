@extends('admin.layouts.app')

@section('title', 'View Project Activity')

@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Project Activity</h1>
            <p class="mt-1 text-sm text-gray-500">View activity details and project association.</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.project-activities.index') }}"
               class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Back
            </a>
            @if(auth()->user()?->hasPermission('project_activities.update'))
                <a href="{{ route('admin.project-activities.edit', $projectActivity) }}"
                   class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                    Edit Activity
                </a>
            @endif
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-5 md:flex-row md:items-start md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ $projectActivity->title_en }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $projectActivity->title_bn }}</p>
            </div>

            @php
                $statusClasses = match ($projectActivity->status) {
                    'completed' => 'bg-green-100 text-green-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                    default => 'bg-amber-100 text-amber-700',
                };
            @endphp
            <span class="inline-flex w-fit rounded-full px-3 py-1 text-xs font-medium {{ $statusClasses }}">
                {{ ucfirst($projectActivity->status) }}
            </span>
        </div>

        <dl class="mt-6 grid gap-6 md:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Project</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $projectActivity->project?->title_en ?? '—' }}</dd>
                @if($projectActivity->project?->title_bn)
                    <dd class="mt-0.5 text-xs text-gray-500">{{ $projectActivity->project->title_bn }}</dd>
                @endif
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Activity Date</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $projectActivity->activity_date?->format('d M Y') ?? '—' }}</dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Location (English)</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $projectActivity->location_en ?? '—' }}</dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Location (Bangla)</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $projectActivity->location_bn ?? '—' }}</dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Sort Order</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $projectActivity->sort_order }}</dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Activity ID</dt>
                <dd class="mt-1 break-all font-mono text-xs text-gray-700">{{ $projectActivity->id }}</dd>
            </div>
        </dl>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-xl border border-gray-200 bg-white p-6">
            <h2 class="text-base font-semibold text-gray-900">Description (English)</h2>
            <div class="mt-4 whitespace-pre-line text-sm leading-6 text-gray-700">
                {{ $projectActivity->description_en ?: 'No English description provided.' }}
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6">
            <h2 class="text-base font-semibold text-gray-900">Description (Bangla)</h2>
            <div class="mt-4 whitespace-pre-line text-sm leading-6 text-gray-700">
                {{ $projectActivity->description_bn ?: 'No Bangla description provided.' }}
            </div>
        </div>
    </div>
</div>
@endsection
