@extends('admin.layouts.app')

@section('title', 'Project Activities')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Project Activities</h1>
            <p class="mt-1 text-sm text-gray-500">Manage activities under your projects.</p>
        </div>

        @if(auth()->user()?->hasPermission('project_activities.create'))
            <a href="{{ route('admin.project-activities.create') }}"
               class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                Create Activity
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="grid gap-3 rounded-xl border border-gray-200 bg-white p-4 md:grid-cols-4">
        <div>
            <label for="search" class="sr-only">Search</label>
            <input id="search" name="search" value="{{ request('search') }}"
                   placeholder="Search activities..."
                   class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-gray-500">
        </div>

        <div>
            <label for="project_id" class="sr-only">Project</label>
            <select id="project_id" name="project_id"
                    class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">
                <option value="">All Projects</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" @selected(request('project_id') == $project->id)>
                        {{ $project->title_en }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status" class="sr-only">Status</label>
            <select id="status" name="status"
                    class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">
                <option value="">All Statuses</option>
                @foreach(['planned', 'completed', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Filter
        </button>
    </form>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Activity</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Project</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Location</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <div class="font-medium text-gray-900">{{ $activity->title_en }}</div>
                                <div class="mt-0.5 text-xs text-gray-500">{{ $activity->title_bn }}</div>
                            </td>

                            <td class="px-4 py-4">
                                <div class="font-medium text-gray-800">{{ $activity->project?->title_en ?? '—' }}</div>
                                @if($activity->project?->slug_en)
                                    <div class="mt-0.5 text-xs text-gray-500">{{ $activity->project->slug_en }}</div>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ $activity->activity_date?->format('d M Y') ?? '—' }}
                            </td>

                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ $activity->location_en ?? '—' }}
                            </td>

                            <td class="px-4 py-4">
                                @php
                                    $statusClasses = match ($activity->status) {
                                        'completed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-amber-100 text-amber-700',
                                    };
                                @endphp
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClasses }}">
                                    {{ ucfirst($activity->status) }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    @if(auth()->user()?->hasPermission('project_activities.view'))
                                        <a href="{{ route('admin.project-activities.show', $activity) }}"
                                           class="rounded border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                            View
                                        </a>
                                    @endif

                                    @if(auth()->user()?->hasPermission('project_activities.update'))
                                        <a href="{{ route('admin.project-activities.edit', $activity) }}"
                                           class="rounded border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                            Edit
                                        </a>
                                    @endif

                                    @if(auth()->user()?->hasPermission('project_activities.delete'))
                                        <form method="POST"
                                              action="{{ route('admin.project-activities.destroy', $activity) }}"
                                              onsubmit="return confirm('Delete this project activity?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-sm text-gray-500">
                                No project activities found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-200 p-4">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
