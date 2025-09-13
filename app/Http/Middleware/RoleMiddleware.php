<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user is active
        if (! $user->is_active) {
            Auth::logout();

            return redirect()->route('login')->withErrors(['account' => 'Your account has been deactivated.']);
        }

        // Check if user has one of the required roles
        // Admins have access to all routes (superuser privileges)
        if (! empty($roles) && $user->role !== 'admin') {
            // Handle comma-separated roles in a single parameter
            $allowedRoles = [];
            foreach ($roles as $role) {
                if (str_contains($role, ',')) {
                    $allowedRoles = array_merge($allowedRoles, explode(',', $role));
                } else {
                    $allowedRoles[] = $role;
                }
            }

            if (! in_array($user->role, $allowedRoles)) {
                abort(403, 'Access denied. You do not have permission to access this resource.');
            }
        }

        return $next($request);
    }
}
