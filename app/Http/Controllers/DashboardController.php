<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalRevenue = DB::table('sales')->sum('total_amount') ?? 0;
        $lowStockProducts = Product::where('stock', '<=', 5)->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalRevenue',
            'lowStockProducts'
        ));
    }
}