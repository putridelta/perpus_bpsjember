<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login')
                ->with('warning', 'Silakan masuk terlebih dahulu untuk mengakses dashboard admin.');
        }

        if (Auth::user()->role !== 'admin') {
            Auth::logout();

            return redirect()->route('admin.login')
                ->with('error', 'Akses ditolak. Akun Anda tidak memiliki hak akses administrator.');
        }

        if (Auth::user()->status !== 'active') {
            Auth::logout();

            return redirect()->route('admin.login')
                ->with('error', 'Akun Anda sedang dinonaktifkan. Hubungi pengelola sistem.');
        }

        return $next($request);
    }
}
