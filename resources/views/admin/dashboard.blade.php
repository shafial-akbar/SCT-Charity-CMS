@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-heading', 'Dashboard')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
    <p class="mt-1 text-sm text-slate-500">Overview of the CMS access-control foundation.</p>
</div>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
@foreach ([
    ['label'=>'Users','value'=>$stats['users']],
    ['label'=>'Active Users','value'=>$stats['active_users']],
    ['label'=>'Roles','value'=>$stats['roles']],
    ['label'=>'Permissions','value'=>$stats['permissions']],
] as $stat)
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</div>
        <div class="mt-2 text-3xl font-bold text-slate-900">{{ number_format($stat['value']) }}</div>
    </div>
@endforeach
</div>

<div class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 px-5 py-4"><h2 class="font-bold text-slate-900">Recent users</h2></div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                <tr><th class="px-5 py-3">User</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Roles</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($recentUsers as $user)
                <tr>
                    <td class="px-5 py-4"><div class="font-semibold text-slate-800">{{ $user->name }}</div><div class="text-xs text-slate-500">{{ $user->email }}</div></td>
                    <td class="px-5 py-4">{{ ucfirst($user->status) }}</td>
                    <td class="px-5 py-4">{{ $user->roles->pluck('name')->join(', ') ?: '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-5 py-8 text-center text-slate-500">No users found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
