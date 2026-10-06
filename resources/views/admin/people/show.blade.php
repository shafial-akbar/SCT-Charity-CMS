@extends('admin.layouts.app')

@section('title', 'View Person')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('admin.people.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900">← Back to People</a>
            <h1 class="mt-3 text-2xl font-bold text-slate-900">{{ $person->name }}</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $person->designation_en ?: $person->designation_bn ?: 'Person' }}</p>
        </div>
        @if(auth()->user()?->hasPermission('people.update'))
            <a href="{{ route('admin.people.edit',$person) }}" class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Edit Person</a>
        @endif
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col items-center text-center">
                @if($person->photo)

                    <img src="{{ asset('storage/' . ltrim($person->photo->file_path, '/')) }}"
                                             alt="{{ $person->photo->alt_text_en ?? $person->name }}"
                                             class="h-36 w-36 rounded-full border border-slate-200 object-cover">
                @else
                    <div class="flex h-36 w-36 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-4xl font-semibold text-slate-400">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($person->name,0,1)) }}</div>
                @endif
                <h2 class="mt-4 text-lg font-bold text-slate-900">{{ $person->name }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $person->designation_en ?: $person->designation_bn ?: '—' }}</p>
                <span class="mt-3 inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold {{ $person->status==='active' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-slate-50 text-slate-600' }}">{{ ucfirst($person->status) }}</span>
            </div>
            <div class="mt-6 space-y-4 border-t border-slate-200 pt-5 text-sm">
                <div><div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Email</div><div class="mt-1 text-slate-700">{{ $person->email ?: '—' }}</div></div>
                <div><div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Phone</div><div class="mt-1 text-slate-700">{{ $person->phone ?: '—' }}</div></div>
            </div>
        </div>

        <div class="space-y-6 lg:col-span-2">
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Biography</h2>
                <div class="mt-5 grid gap-6 md:grid-cols-2">
                    <div><h3 class="text-xs font-semibold uppercase tracking-wide text-slate-400">English</h3><div class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-700">{{ $person->biography_en ?: '—' }}</div></div>
                    <div><h3 class="text-xs font-semibold uppercase tracking-wide text-slate-400">Bangla</h3><div class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-700">{{ $person->biography_bn ?: '—' }}</div></div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Chairman / Leadership Message</h2>
                <div class="mt-5 grid gap-6 md:grid-cols-2">
                    <div><h3 class="text-xs font-semibold uppercase tracking-wide text-slate-400">English</h3><div class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-700">{{ $person->message_en ?: '—' }}</div></div>
                    <div><h3 class="text-xs font-semibold uppercase tracking-wide text-slate-400">Bangla</h3><div class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-700">{{ $person->message_bn ?: '—' }}</div></div>
                </div>
            </section>

            @if($person->social_links)
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Social Links</h2>
                <pre class="mt-4 overflow-x-auto rounded-xl border border-gray-300 bg-slate-50 p-4 text-xs text-slate-700">{{ json_encode($person->social_links, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
            </section>
            @endif
        </div>
    </div>
</div>
@endsection
