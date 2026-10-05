<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function index(Request $request): View
    {
        $module = trim((string) $request->query('module'));

        $permissions = Permission::query()
            ->when($module !== '', fn ($query) => $query->where('module', $module))
            ->orderBy('module')->orderBy('slug')
            ->paginate(25)->withQueryString();

        $modules = Permission::query()
            ->select('module')->distinct()->orderBy('module')->pluck('module');

        return view('admin.access.permissions.index', compact('permissions', 'modules', 'module'));
    }
}
