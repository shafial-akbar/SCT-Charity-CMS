@extends('admin.layouts.app')

@section('title', 'People')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">People</h1>
            <p class="mt-1 text-sm text-gray-500">Manage people, leadership profiles and messages.</p>
        </div>

        @if(auth()->user()?->hasPermission('people.create'))
            <a href="{{ route('admin.people.create') }}"
               class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                Create Person
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
               placeholder="Search name, designation or contact..."
               class="min-w-[240px] flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">

        <select name="status"
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
            <option value="">All statuses</option>
            @foreach(['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
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
                        <th class="px-6 py-3">Person</th>
                        <th class="px-6 py-3">Designation</th>
                        <th class="px-6 py-3">Contact</th>
                        <th class="px-6 py-3">Order</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($people as $person)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($person->photo)
                                        <img src="{{ asset('storage/' . ltrim($person->photo->file_path, '/')) }}"
                                             alt="{{ $person->photo->alt_text_en ?? $person->name }}"
                                             class="h-12 w-12 rounded-lg border border-gray-200 object-cover">
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg border border-gray-200 bg-gray-50 text-sm font-medium text-gray-500">
                                            {{ strtoupper(substr($person->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <div class="font-medium text-gray-900">{{ $person->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $person->designation_bn ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $person->designation_en ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                <div>{{ $person->email ?? '—' }}</div>
                                <div>{{ $person->phone ?? '' }}</div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $person->sort_order }}
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $statusClass = $person->status === 'active'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }}">
                                    {{ ucfirst($person->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                @if(auth()->user()?->hasPermission('people.view'))
                                    <a href="{{ route('admin.people.show', $person) }}"
                                       class="inline-flex rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        View
                                    </a>
                                @endif

                                @if(auth()->user()?->hasPermission('people.update'))
                                    <a href="{{ route('admin.people.edit', $person) }}"
                                       class="ml-2 inline-flex rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Edit
                                    </a>
                                @endif

                                @if(auth()->user()?->hasPermission('people.delete'))
                                    <form method="POST"
                                          action="{{ route('admin.people.destroy', $person) }}"
                                          class="ml-2 inline"
                                          onsubmit="return confirm('Delete this person?')">
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
                                No people found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-100 px-6 py-4">
            {{ $people->links() }}
        </div>
    </div>
</div>
@endsection
