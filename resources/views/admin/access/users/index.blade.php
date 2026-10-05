@extends('admin.layouts.app')
@section('title', 'Users')
@section('page-heading', 'Users')
@section('content')
<div class="mb-6"><h1 class="text-2xl font-bold text-slate-900">Users</h1><p class="mt-1 text-sm text-slate-500">Read-only foundation view.</p></div>
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
<table class="min-w-full divide-y divide-slate-100 text-sm">
<thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500"><tr><th class="px-5 py-3">Name</th><th class="px-5 py-3">Email</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Roles</th></tr></thead>
<tbody class="divide-y divide-slate-100">
@foreach ($users as $user)
<tr><td class="px-5 py-4 font-semibold">{{ $user->name }}</td><td class="px-5 py-4">{{ $user->email }}</td><td class="px-5 py-4">{{ ucfirst($user->status) }}</td><td class="px-5 py-4">{{ $user->roles->pluck('name')->join(', ') ?: '—' }}</td></tr>
@endforeach
</tbody>
</table>
<div class="border-t border-slate-100 px-5 py-4">{{ $users->links() }}</div>
</div>
@endsection
