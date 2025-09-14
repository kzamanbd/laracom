<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureVendorRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
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

        // Check if user has vendor role or is admin (admins can access vendor areas)
        if (! in_array($user->role, ['vendor', 'admin'])) {
            abort(403, 'Access denied. You must be a vendor to access this area.');
        }

        // If user is a vendor, check if they have a vendor profile
        if ($user->role === 'vendor') {
            // Check if vendor relationship exists
            if (! $user->relationLoaded('vendor') && ! $user->vendor) {
                abort(403, 'Vendor profile not found. Please complete your vendor registration.');
            }

            // Optional: Check vendor status if vendor model exists
            if ($user->vendor && isset($user->vendor->status) && $user->vendor->status !== 'active') {
                abort(403, 'Your vendor account is not active. Please contact support.');
            }
        }

        return $next($request);
    }
}
