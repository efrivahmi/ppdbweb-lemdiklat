<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin\SchoolSetting;
use Illuminate\Support\Facades\Cache;

class CheckPpdbOpen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settings = Cache::rememberForever('school_settings', function () {
            return SchoolSetting::first();
        });

        // Allow access to the /ppdb-closed page to prevent redirect loops
        if ($request->routeIs('siswa.ppdb-closed')) {
            return $next($request);
        }

        // If settings exist and PPDB is closed
        if ($settings && !$settings->is_ppdb_open) {
            // Allow admin/guru routes, but redirect siswa routes
            if ($request->is('siswa/*') || $request->is('siswa')) {
                return redirect()->route('siswa.ppdb-closed');
            }
        }

        return $next($request);
    }
}
