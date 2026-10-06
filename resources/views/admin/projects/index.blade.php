@extends('admin.layouts.app')

@section('title', 'Projects')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Projects</h1>
            <p class="mt-1 text-sm text-gray-500">Manage projects under programs.</p>
        </div>

        @if(auth()->user()?->hasPermission('projects.create'))
            <a href="{{ route('admin.projects.create') }}"
               class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                Create Project
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">
            Please fix the highlighted fields and try again.
        </div>
    @endif

    <form method="GET" class="flex flex-wrap gap-3 rounded-xl border border-gray-200 bg-white p-4">
        <input name="search"
               value="{{ request('search') }}"
               placeholder="Search title, slug or location..."
               class="min-w-[240px] flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">

        <select name="program_id"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
            <option value="">All Programs</option>
            @foreach($programs as $program)
                <option value="{{ $program->id }}" @selected(request('program_id') == $program->id)>
                    {{ $program->title_en }}
                </option>
            @endforeach
        </select>

        <select name="status"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
            <option value="">All statuses</option>
            @foreach(['draft' => 'Draft', 'planned' => 'Planned', 'active' => 'Active', 'completed' => 'Completed', 'archived' => 'Archived'] as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>

        <button type="submit"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Filter
        </button>
    </form>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        <th class="px-6 py-3">Project</th>
                        <th class="px-6 py-3">Program</th>
                        <th class="px-6 py-3">Location</th>
                        <th class="px-6 py-3">Dates</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($project->featuredImage)
                                        <img src="{{ asset('storage/' . ltrim($project->featuredImage->file_path, '/')) }}"
                                             alt="{{ $project->featuredImage->alt_text_en ?? $project->title_en }}"
                                             class="h-12 w-16 rounded-lg border border-gray-200 object-cover">
                                    @else
                                        <div class="h-12 w-16 rounded-lg border border-gray-200 bg-gray-50"></div>
                                    @endif

                                    <div>
                                        <div class="font-medium text-gray-900">{{ $project->title_en }}</div>
                                        <div class="text-sm text-gray-500">{{ $project->title_bn }}</div>
                                        <div class="mt-1 text-xs text-gray-400">{{ $project->slug_en }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $project->program?->title_en ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $project->location_en ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                {{ $project->start_date?->format('d M Y') ?? '—' }}
                                @if($project->end_date)
                                    <span class="text-gray-400">→</span> {{ $project->end_date->format('d M Y') }}
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match($project->status) {
                                        'active' => 'bg-green-100 text-green-700',
                                        'completed' => 'bg-blue-100 text-blue-700',
                                        'planned' => 'bg-yellow-100 text-yellow-700',
                                        'draft' => 'bg-gray-100 text-gray-600',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                @if(auth()->user()?->hasPermission('projects.update'))
                                    <a href="{{ route('admin.projects.edit', $project) }}"
                                       class="inline-flex rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Edit
                                    </a>
                                @endif

                                @if(auth()->user()?->hasPermission('projects.delete'))
                                    <form method="POST"
                                          action="{{ route('admin.projects.destroy', $project) }}"
                                          class="ml-2 inline"
                                          onsubmit="return confirm('Delete this project?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex rounded-lg border border-red-200 bg-white px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                No projects found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-100 px-6 py-4">
            {{ $projects->links() }}
        </div>
    </div>
</div>
@endsection
