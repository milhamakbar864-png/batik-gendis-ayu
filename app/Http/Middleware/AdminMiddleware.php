<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu untuk mengakses halaman administrator.');
        }

        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Administrator Batik Gendis Ayu.');
        }

        return $next($request);
    }
}
