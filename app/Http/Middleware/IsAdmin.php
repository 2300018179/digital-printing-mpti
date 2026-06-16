<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login, dan apakah role-nya ADALAH 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Diloloskan masuk ke dashboard admin
        }

        // 2. Jika bukan admin, tendang balik ke halaman utama
        return redirect('/')->with('error', 'Anda tidak memiliki hak akses admin.');
    }
}