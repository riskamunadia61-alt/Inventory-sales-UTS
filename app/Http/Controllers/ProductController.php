<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();

        return view('dashboard', compact('totalProducts'));
    }

    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => ['required', 'string', 'max:255', 'unique:products,product_code'],
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_code' => ['required', 'string', 'max:255', 'unique:products,product_code,' . $product->id],
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->saleItems()->exists() || $product->purchaseItems()->exists()) {
            return back()->with('error', 'Produk tidak dapat dihapus karena sudah terikat dengan riwayat transaksi.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}