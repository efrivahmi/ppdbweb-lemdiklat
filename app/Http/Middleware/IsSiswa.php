<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsSiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        // Jika sudah login dan bukan admin
        if(!Auth::user()->isSiswa()) {
            return redirect()->back();
        } 

        return $next($request);
    }
}
