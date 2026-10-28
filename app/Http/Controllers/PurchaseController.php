<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['product', 'supplier'])->latest()->get();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        
        return view('purchases.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_number' => 'required|unique:purchases,purchase_number',
            'supplier_id'     => 'required',
            'product_id'      => 'required|exists:products,id',
            'quantity'        => 'required|integer|min:1',
            'purchase_price'  => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $supplierId = $request->supplier_id;
            if (!Supplier::find($supplierId)) {
                $firstSupplier = Supplier::first();
                if ($firstSupplier) {
                    $supplierId = $firstSupplier->id;
                } else {
                    $newSupplier = Supplier::create([
                        'name' => 'Supplier Utama Dior'
                    ]);
                    $supplierId = $newSupplier->id;
                }
            }

            // Simpan transaksi restok dengan data lengkap dan perkalian total_amount yang benar
            Purchase::create([
                'purchase_number' => $request->purchase_number,
                'supplier_id'     => $supplierId,
                'product_id'      => $request->product_id,
                'quantity'        => $request->quantity,
                'purchase_price'  => $request->purchase_price,
                'total_amount'    => $request->purchase_price * $request->quantity,
                'purchase_date'   => date('Y-m-d'),
            ]);

            // Update stok produk secara otomatis
            $product = Product::findOrFail($request->product_id);
            $product->stock += $request->quantity;
            $product->save();

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'Riwayat restok berhasil ditambahkan dan stok produk diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan restok.']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::findOrFail($id);

            // Kurangi kembali stok produk karena riwayat restok dihapus
            $product = Product::find($purchase->product_id);
            if ($product) {
                $product->stock -= $purchase->quantity;
                $product->save();
            }

            // Hapus data restok
            $purchase->delete();

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'Riwayat restok berhasil dihapus dan stok disesuaikan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menghapus riwayat restok.']);
        }
    }
}