@csrf

<div class="space-y-6">
    <div class="rounded-xl border border-gray-200 bg-white p-5">
        <h2 class="text-base font-semibold text-gray-900">Activity Information</h2>
        <p class="mt-1 text-sm text-gray-500">Provide the activity details in both supported languages.</p>

        <div class="mt-5 grid gap-6 md:grid-cols-2">
            <div>
                <label for="project_id" class="block text-sm font-medium text-gray-700">Project <span class="text-red-500">*</span></label>
                <select id="project_id" name="project_id" required
                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">
                    <option value="">Select project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" @selected(old('project_id', $projectActivity->project_id ?? '') == $project->id)>
                            {{ $project->title_en }} @if($project->title_bn) — {{ $project->title_bn }} @endif
                        </option>
                    @endforeach
                </select>
                @error('project_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="activity_date" class="block text-sm font-medium text-gray-700">Activity Date</label>
                <input id="activity_date" type="date" name="activity_date"
                       value="{{ old('activity_date', isset($projectActivity?->activity_date) ? $projectActivity->activity_date->format('Y-m-d') : '') }}"
                       class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">
                @error('activity_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="title_en" class="block text-sm font-medium text-gray-700">Title (English) <span class="text-red-500">*</span></label>
                <input id="title_en" type="text" name="title_en" required
                       value="{{ old('title_en', $projectActivity->title_en ?? '') }}"
                       class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">
                @error('title_en')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="title_bn" class="block text-sm font-medium text-gray-700">Title (Bangla) <span class="text-red-500">*</span></label>
                <input id="title_bn" type="text" name="title_bn" required
                       value="{{ old('title_bn', $projectActivity->title_bn ?? '') }}"
                       class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">
                @error('title_bn')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="location_en" class="block text-sm font-medium text-gray-700">Location (English)</label>
                <input id="location_en" type="text" name="location_en"
                       value="{{ old('location_en', $projectActivity->location_en ?? '') }}"
                       class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">
                @error('location_en')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="location_bn" class="block text-sm font-medium text-gray-700">Location (Bangla)</label>
                <input id="location_bn" type="text" name="location_bn"
                       value="{{ old('location_bn', $projectActivity->location_bn ?? '') }}"
                       class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">
                @error('location_bn')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select id="status" name="status" required
                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">
                    @foreach(['planned', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $projectActivity->status ?? 'planned') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                <input id="sort_order" type="number" name="sort_order" min="0"
                       value="{{ old('sort_order', $projectActivity->sort_order ?? 0) }}"
                       class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">
                <p class="mt-1 text-xs text-gray-500">Lower numbers appear first.</p>
                @error('sort_order')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5">
        <h2 class="text-base font-semibold text-gray-900">Description</h2>

        <div class="mt-5 grid gap-6 md:grid-cols-2">
            <div>
                <label for="description_en" class="block text-sm font-medium text-gray-700">Description (English)</label>
                <textarea id="description_en" name="description_en" rows="8"
                          class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">{{ old('description_en', $projectActivity->description_en ?? '') }}</textarea>
                @error('description_en')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description_bn" class="block text-sm font-medium text-gray-700">Description (Bangla)</label>
                <textarea id="description_bn" name="description_bn" rows="8"
                          class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500">{{ old('description_bn', $projectActivity->description_bn ?? '') }}</textarea>
                @error('description_bn')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>
</div>

<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('admin.project-activities.index') }}"
       class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
        Cancel
    </a>
    <button type="submit"
            class="rounded-lg bg-gray-900 px-5 py-2 text-sm font-medium text-white hover:bg-gray-800">
        {{ $submitLabel ?? 'Save Activity' }}
    </button>
</div>
