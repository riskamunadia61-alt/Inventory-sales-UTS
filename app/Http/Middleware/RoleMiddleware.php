<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $userRole = strtolower(trim($user->role ?? ''));

        // Jika akun adalah admin, berikan akses penuh
        if ($userRole === 'admin') {
            return $next($request);
        }

        // Jika akun adalah staf / kasir (mendukung penulisan staff, staf, kasir, cashier)
        $staffRoles = ['staff', 'staf', 'kasir', 'cashier'];
        if (in_array($userRole, $staffRoles)) {
            // Jika staf mencoba akses halaman utama atau dashboard, alihkan otomatis ke /sales
            if ($request->is('/') || $request->is('dashboard')) {
                return redirect('/sales');
            }

            // Izinkan akses ke menu penjualan, produk, dll.
            if ($request->is('sales*') || $request->is('products*')) {
                return $next($request);
            }
        }

        // Jika tidak memiliki izin
        abort(403, 'AKSES DITOLAK. ANDA TIDAK MEMILIKI IZIN UNTUK MENGAKSES HALAMAN INI.');
    }
}