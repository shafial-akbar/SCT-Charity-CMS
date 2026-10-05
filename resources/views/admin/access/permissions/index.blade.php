@extends('admin.layouts.app')
@section('title', 'Permissions')
@section('page-heading', 'Permissions')
@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
<div><h1 class="text-2xl font-bold text-slate-900">Permissions</h1><p class="mt-1 text-sm text-slate-500">Same slugs protect web and API routes.</p></div>
<form method="GET" class="flex gap-2">
<select name="module" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
<option value="">All modules</option>
@foreach ($modules as $moduleName)<option value="{{ $moduleName }}" @selected($module === $moduleName)>{{ $moduleName }}</option>@endforeach
</select>
<button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Filter</button>
</form>
</div>
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
<table class="min-w-full divide-y divide-slate-100 text-sm">
<thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500"><tr><th class="px-5 py-3">Permission</th><th class="px-5 py-3">Slug</th><th class="px-5 py-3">Module</th><th class="px-5 py-3">Action</th></tr></thead>
<tbody class="divide-y divide-slate-100">
@foreach ($permissions as $permission)
<tr><td class="px-5 py-4 font-semibold">{{ $permission->name }}</td><td class="px-5 py-4 font-mono text-xs">{{ $permission->slug }}</td><td class="px-5 py-4">{{ $permission->module }}</td><td class="px-5 py-4">{{ $permission->action }}</td></tr>
@endforeach
</tbody>
</table>
<div class="border-t border-slate-100 px-5 py-4">{{ $permissions->links() }}</div>
</div>
@endsection
