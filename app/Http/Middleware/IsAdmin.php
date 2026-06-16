<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN apakah rolenya adalah admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Diizinkan masuk halaman admin
        }

        // Jika bukan admin, tendang balik ke halaman login dengan pesan error
        return redirect()->route('login')->with('error', 'Akses ditolak! Anda bukan admin.');
    }
}