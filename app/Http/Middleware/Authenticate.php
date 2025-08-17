<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Cek prefix URL untuk menentukan login page
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');
        }

        return route('user.login'); // fallback login user
    }
}
