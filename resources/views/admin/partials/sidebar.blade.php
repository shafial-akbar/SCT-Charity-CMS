@php($adminUser = auth()->user())
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-72 transform border-r border-slate-800 bg-slate-950 transition-transform duration-200 lg:translate-x-0">
    <div class="flex h-20 items-center border-b border-slate-800 px-6">
        <div>
            <div class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-400">SCT</div>
            <div class="mt-1 text-lg font-bold text-white">CMS Admin</div>
        </div>
    </div>

    <nav class="flex h-[calc(100vh-5rem)] flex-col overflow-y-auto px-4 py-5">
        <div class="space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">
                Dashboard
            </a>

            @if ($adminUser?->hasPermission('users.view') || $adminUser?->hasPermission('roles.view') || $adminUser?->hasPermission('permissions.view'))
                <div class="px-3 pb-1 pt-6 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Access Control</div>

                @if ($adminUser?->hasPermission('users.view'))
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">Users</a>
                @endif

                @if ($adminUser?->hasPermission('roles.view'))
                    <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">Roles</a>
                @endif

                @if ($adminUser?->hasPermission('permissions.view'))
                    <a href="{{ route('admin.permissions.index') }}" class="{{ request()->routeIs('admin.permissions.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">Permissions</a>
                @endif
            @endif

            <div class="px-3 pb-1 pt-6 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">CMS</div>
            @if ($adminUser?->hasPermission('pages.view'))
                    <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">Pages</a>
            @endif
            @if ($adminUser?->hasPermission('programs.view'))
                    <a href="{{ route('admin.programs.index') }}" class="{{ request()->routeIs('admin.programs.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">Programs</a>
            @endif
            @if ($adminUser?->hasPermission('programs.view'))
                <a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">Projects</a>
            @endif
            @if ($adminUser?->hasPermission('people.view'))
                <a href="{{ route('admin.people.index') }}"
                class="{{ request()->routeIs('admin.people.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">
                    People
                </a>
            @endif
            @if ($adminUser?->hasPermission('galleries.view'))
                <a href="{{ route('admin.galleries.index') }}"
                class="{{ request()->routeIs('admin.galleries.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">
                    Galleries
                </a>
            @endif
            @if ($adminUser?->hasPermission('gallery_categories.view'))
                <a href="{{ route('admin.gallery-categories.index') }}"
                class="{{ request()->routeIs('admin.gallery-categories.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">
                    Gallery Categories
                </a>
            @endif
            @if ($adminUser?->hasPermission('gallery_photos.view'))
                <a href="{{ route('admin.gallery-photos.index') }}"
                class="{{ request()->routeIs('admin.gallery-photos.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">
                    Gallery Photos
                </a>
            @endif
            @if ($adminUser?->hasPermission('project_activities.view'))
                <a href="{{ route('admin.project-activities.index') }}"
                class="{{ request()->routeIs('admin.project-activities.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} flex items-center rounded-xl px-3 py-2.5 text-sm font-medium">
                    Project Activities
                </a>
            @endif
        </div>

        <div class="mt-auto border-t border-slate-800 pt-4">
            <div class="px-3 text-xs text-slate-500">Signed in as</div>
            <div class="mt-1 truncate px-3 text-sm font-semibold text-slate-200">{{ $adminUser?->name }}</div>
        </div>
    </nav>
</aside>
