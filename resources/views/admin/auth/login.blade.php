<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — {{ config('app.name', 'SCT CMS') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-full items-center justify-center px-4 py-12">
<div class="w-full max-w-md">
    <div class="mb-8 text-center">
        <div class="text-xs font-bold uppercase tracking-[0.25em] text-sky-400">Shaheen Cares Trust</div>
        <h1 class="mt-3 text-3xl font-bold text-white">CMS Admin</h1>
        <p class="mt-2 text-sm text-slate-400">Sign in with your administrator account.</p>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6 shadow-2xl sm:p-8">
        @if (session('success'))
            <div class="mb-5 rounded-lg border border-emerald-800 bg-emerald-950/60 px-4 py-3 text-sm text-emerald-300">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-rose-800 bg-rose-950/60 px-4 py-3 text-sm text-rose-300">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-200">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
                       placeholder="admin@example.com">
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-200">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500">
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-400">
                <input type="checkbox" name="remember" value="1" class="rounded border-slate-600"> Remember me
            </label>
            <button type="submit" class="w-full rounded-xl bg-sky-500 px-4 py-3 text-sm font-bold text-white hover:bg-sky-400">Sign in</button>
        </form>
    </div>
</div>
</body>
</html>
