<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class CheckRememberMe
{
    public function handle($request, Closure $next)
    {
        // Periksa jika pengguna login dan menggunakan opsi "remember me"
        if (Auth::check() && Auth::viaRemember()) {
            // Set durasi sesi lebih lama (misalnya, 2 minggu)
            Config::set('session.lifetime', 20160); // 2 minggu dalam menit
            Config::set('session.expire_on_close', false);
        } else {
            // Jika tidak ada "remember me", sesi akan berakhir saat browser ditutup
            Config::set('session.expire_on_close', true);
        }

        return $next($request);
    }
}
