<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoleMiddleware extends BaseMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $roles = $request->user()->roles->toArray();

        $check_roles = explode(',', $role);
        if (! $this->hasRole($roles, $check_roles)) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have access.');
        }

        return $next($request);
    }
}
