<header class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-slate-200 bg-white/95 px-4 backdrop-blur sm:px-6 lg:px-8">
    <div class="flex items-center gap-3">
        <button type="button" class="rounded-lg border border-slate-200 p-2 text-slate-600 lg:hidden" @click="sidebarOpen = true">☰</button>
        <div>
            <div class="text-xs font-medium uppercase tracking-wide text-slate-400">Administration</div>
            <div class="text-sm font-semibold text-slate-700">@yield('page-heading', 'Dashboard')</div>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <div class="hidden text-right sm:block">
            <div class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</div>
            <div class="text-xs text-slate-500">{{ auth()->user()->roles->pluck('name')->join(', ') ?: 'No role' }}</div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Logout</button>
        </form>
    </div>
</header>
