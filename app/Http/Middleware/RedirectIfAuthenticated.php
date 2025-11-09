<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Kalau admin login
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                // Kalau pasien login
                if ($guard === 'pasien') {
                    return redirect()->route('user.home');
                }

                // Default (fallback)
                return redirect('/');
            }
        }

        return $next($request);
    }
}
