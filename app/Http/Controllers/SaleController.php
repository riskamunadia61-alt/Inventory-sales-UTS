<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->latest()->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|unique:sales,invoice_number',
            'product_id'     => 'required|exists:products,id',
            'quantity'       => 'required|integer|min:1',
            'customer_name'  => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($request->product_id);

            // Cek apakah stok mencukupi
            if ($product->stock < $request->quantity) {
                return back()->withErrors(['quantity' => 'Stok produk tidak mencukupi! Stok saat ini: ' . $product->stock])->withInput();
            }

            // Hitung total amount
            $totalAmount = $product->selling_price * $request->quantity;

            // Simpan transaksi penjualan dan tampung ke variabel $sale
            $sale = Sale::create([
                'invoice_number' => $request->invoice_number,
                'customer_name'  => $request->customer_name,
                'product_id'     => $request->product_id,
                'quantity'       => $request->quantity,
                'total_amount'   => $totalAmount,
                'paid_amount'    => $totalAmount,
                'change_amount'  => 0,
                'sale_date'      => date('Y-m-d'),
            ]);

            // Kurangi stok produk secara otomatis
            $product->stock -= $request->quantity;
            $product->save();

            DB::commit();

            // Langsung arahkan ke halaman struk pembelian setelah transaksi berhasil
            return redirect()->route('sales.show', $sale->id)->with('success', 'Transaksi penjualan berhasil disimpan dan stok berkurang.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan transaksi.']);
        }
    }

    // Method untuk menampilkan detail / nota pembelian
    public function show($id)
    {
        $sale = Sale::with(['product'])->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    // Method untuk mencetak struk pembelian
    public function receipt($id)
    {
        $sale = Sale::with(['product'])->findOrFail($id);
        return view('sales.receipt', compact('sale'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $sale = Sale::findOrFail($id);

            // Kembalikan stok produk sebelum transaksi dihapus
            $product = Product::find($sale->product_id);
            if ($product) {
                $product->stock += $sale->quantity;
                $product->save();
            }

            // Hapus data penjualan
            $sale->delete();

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Transaksi penjualan berhasil dihapus dan stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menghapus transaksi.']);
        }
    }
}