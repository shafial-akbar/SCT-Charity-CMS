<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Usage:
     * ->middleware('permission:projects.view')
     *
     * Multiple permissions use OR logic:
     * ->middleware('permission:projects.view,projects.update')
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$permissions
    ): Response {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        foreach ($permissions as $permission) {
            if ($user->hasPermission($permission)) {
                return $next($request);
            }
        }

        return response()->json([
            'message' => 'Forbidden.',
            'error' => 'You do not have permission to perform this action.',
        ], 403);
    }
}
