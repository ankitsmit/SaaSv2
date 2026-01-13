<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($type === 'super_admin' && !$user->isSuperAdmin()) {
            abort(403, 'Access denied. Super Admin only.');
        }

        if ($type === 'client' && !$user->isClient()) {
            abort(403, 'Access denied. Client access only.');
        }

        return $next($request);
    }
}
