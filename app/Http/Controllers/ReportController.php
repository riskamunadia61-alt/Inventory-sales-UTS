<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Sale::with(['product']);

        // Filter pencarian berdasarkan ID atau nama pelanggan
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan rentang tanggal yang fleksibel
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Menghitung total transaksi dan pendapatan secara akurat berdasarkan hasil filter
        $statsQuery = clone $query;
        $totalTransactions = $statsQuery->count();
        $totalRevenue = $statsQuery->get()->sum(function ($sale) {
            return $sale->total ?? $sale->total_amount ?? 0;
        });

        // Ambil data dengan paginasi (10 data per halaman)
        $sales = $query->latest()->paginate(10);

        return view('reports.index', compact('sales', 'totalTransactions', 'totalRevenue', 'search', 'startDate', 'endDate'));
    }
}