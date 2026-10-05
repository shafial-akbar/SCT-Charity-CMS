@extends('admin.layouts.app')

@section('title', 'Create User')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">

    <div>
        <a href="{{ route('admin.users.index') }}"
           class="text-sm font-medium text-gray-500 hover:text-gray-900">
            ← Back to Users
        </a>

        <h1 class="mt-3 text-2xl font-semibold text-gray-900">Create User</h1>
        <p class="mt-1 text-sm text-gray-500">
            Create a new CMS user and assign one or more roles.
        </p>
    </div>

    @if ($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4">
            <p class="text-sm font-semibold text-red-800">Please correct the following:</p>
            <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.users.store') }}"
          class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        @csrf

        <div class="grid gap-6 sm:grid-cols-2">

            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-gray-700">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}"
                       required autocomplete="name" placeholder="Full name"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-200">
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                       required autocomplete="email" placeholder="user@example.com"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-200">
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                       autocomplete="new-password" placeholder="Minimum 8 characters"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-200">
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-gray-700">
                    Confirm Password
                </label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                       required autocomplete="new-password" placeholder="Repeat password"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-200">
            </div>

            <div>
                <label for="status" class="mb-2 block text-sm font-semibold text-gray-700">Status</label>
                <select id="status" name="status"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                    <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                </select>
            </div>

            {{-- Roles --}}
            <div class="sm:col-span-2">
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Roles
                </label>

                <div class="rounded-lg border border-gray-300 bg-white p-4">
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach($roles as $role)
                            <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 px-4 py-3 hover:bg-gray-50">
                                <input
                                    type="checkbox"
                                    name="roles[]"
                                    value="{{ $role->id }}"
                                    @checked(in_array($role->id, old('roles', []), true))
                                    class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-500"
                                >
                                <span class="text-sm font-medium text-gray-700">
                                    {{ $role->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <p class="mt-2 text-xs text-gray-500">
                    Select one or more roles for this user.
                </p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
            <a href="{{ route('admin.users.index') }}"
               class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </a>

            <button type="submit"
                    class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                Create User
            </button>
        </div>
    </form>
</div>
@endsection
