<form method="POST" action="{{ $action }}" class="space-y-6 rounded-xl border border-gray-200 bg-white p-6">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    @if($errors->any())
        <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">Name</label>
        <input name="name" value="{{ old('name', $user?->name) }}" required
               class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500">
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $user?->email) }}" required
               class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500">
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Password {{ $user ? '(leave blank to keep current)' : '' }}
            </label>
            <input type="password" name="password" {{ $user ? '' : 'required' }}
                   class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" {{ $user ? '' : 'required' }}
                   class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500">
        </div>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500">
            <option value="active" @selected(old('status', $user?->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $user?->status) === 'inactive')>Inactive</option>
        </select>
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Roles</label>
        <div class="grid gap-3 md:grid-cols-2">
            @php($selectedRoles = old('roles', $user?->roles?->pluck('id')->all() ?? []))
            @foreach($roles as $role)
                <label class="flex items-center gap-3 rounded-lg border border-gray-200 p-3">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                           @checked(in_array($role->id, $selectedRoles))
                           class="rounded border-gray-300 text-gray-900 focus:ring-gray-500">
                    <span>
                        <span class="block text-sm font-medium text-gray-800">{{ $role->name }}</span>
                        <span class="block text-xs text-gray-500">{{ $role->slug }}</span>
                    </span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5">
        <a href="{{ route('admin.users.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium hover:bg-gray-50">Cancel</a>
        <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">{{ $submitLabel }}</button>
    </div>
</form>
