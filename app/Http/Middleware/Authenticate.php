<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // 1. Jika URL yang diminta adalah URL admin (diawali 'admin/...')
        //    makaarahkan ke 'admin.login'
        if ($request->is('admin/*')) {
            return route('admin.login');
        }

        // 2. Jika URL yang diminta adalah URL user (diawali 'user/...')
        //    maka arahkan ke 'user.login'
        if ($request->is('user/*')) {
            return route('user.login');
        }

        // 3. Sebagai default, jika tidak ada yang cocok
        //    (misalnya middleware 'auth' dipanggil di URL root),
        //    kita arahkan ke login admin (sesuai logika di web.php Anda).
        return route('admin.login');
    }
}