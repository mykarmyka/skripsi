<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated 
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Jika user adalah admin
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                // Jika user adalah pasien
                if ($guard === 'pasien') {
                    return redirect()->route('user.home');
                }

                // Fallback default
                return redirect('/home');
            }
        }

        return $next($request);
    }

}