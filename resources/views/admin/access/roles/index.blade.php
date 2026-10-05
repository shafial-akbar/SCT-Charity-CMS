@extends('admin.layouts.app')
@section('title', 'Roles')
@section('page-heading', 'Roles')
@section('content')
<div class="mb-6"><h1 class="text-2xl font-bold text-slate-900">Roles</h1><p class="mt-1 text-sm text-slate-500">Shared by Admin Panel and Admin API.</p></div>
<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
@foreach ($roles as $role)
<article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
<h2 class="font-bold text-slate-900">{{ $role->name }}</h2>
<div class="mt-1 font-mono text-xs text-slate-400">{{ $role->slug }}</div>
<p class="mt-4 text-sm text-slate-500">{{ $role->description }}</p>
<div class="mt-4 text-sm text-slate-600">{{ $role->users_count }} users · {{ $role->permissions_count }} permissions</div>
</article>
@endforeach
</div>
@endsection
