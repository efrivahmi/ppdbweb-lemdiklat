<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGuruAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission = null): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized access');
        }

        // Check specific permission
        switch ($permission) {
            case 'manage-soal':
                if (!$user->canManageSoal()) {
                    abort(403, 'Anda tidak memiliki akses untuk mengelola soal');
                }
                break;

            case 'manage-users':
                if (!$user->canManageUsers()) {
                    abort(403, 'Hanya admin yang dapat mengelola pengguna');
                }
                break;

            case 'create-custom-test':
                if (!$user->canCreateCustomTest()) {
                    abort(403, 'Anda tidak memiliki akses untuk membuat custom test');
                }
                break;

            case 'manage-custom-test':
                if (!$user->canCreateCustomTest()) {
                    abort(403, 'Anda tidak memiliki akses untuk mengelola custom test');
                }
                break;

            case 'view-siswa-data':
                if (!$user->canViewSiswaData()) {
                    abort(403, 'Anda tidak memiliki akses untuk melihat data siswa');
                }
                break;

            case 'guru-only':
                if (!$user->isGuru()) {
                    abort(403, 'Akses khusus guru');
                }
                break;

            case 'admin-only':
                if (!$user->isAdmin()) {
                    abort(403, 'Akses khusus admin');
                }
                break;

            default:
                // No specific permission check
                break;
        }

        return $next($request);
    }
}
