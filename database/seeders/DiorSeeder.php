<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;

class DiorSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Kategori Tas Dior
        $cat1 = Category::create(['name' => 'Lady Dior', 'description' => 'Kategori tas ikonik Lady Dior dengan desain klasik dan elegan']);
        $cat2 = Category::create(['name' => 'Dior Book Tote', 'description' => 'Tas tote lapang dengan bordir motif khas Dior']);
        $cat3 = Category::create(['name' => 'Saddle Bag', 'description' => 'Tas klasik berbentuk pelana kuda yang trendi']);

        // 2. Buat Supplier / Pemasok
        $supplier = Supplier::create([
            'name' => 'Dior Official Boutique Paris',
            'phone' => '+33140737373',
            'address' => '30 Avenue Montaigne, Paris, France'
        ]);

        // 3. Buat Produk Tas Dior (Tema Monokrom: Hitam, Putih, Abu-abu)
        Product::create([
            'category_id' => $cat1->id,
            'code' => 'DIOR-LD-01',
            'name' => 'Medium Lady Dior Bag Black Lambskin',
            'purchase_price' => 70000000,
            'selling_price' => 85000000,
            'stock' => 5,
            'description' => 'Tas Lady Dior medium berwarna hitam pekat dengan lambskin Cannage dan aksesoris metal warna silver.'
        ]);

        Product::create([
            'category_id' => $cat2->id,
            'code' => 'DIOR-BT-02',
            'name' => 'Large Dior Book Tote White & Black',
            'purchase_price' => 40000000,
            'selling_price' => 50000000,
            'stock' => 8,
            'description' => 'Dior Book Tote motif Oblique kombinasi warna monokrom hitam dan putih yang mewah.'
        ]);

        Product::create([
            'category_id' => $cat3->id,
            'code' => 'DIOR-SD-03',
            'name' => 'Dior Saddle Bag Monochrome Grey',
            'purchase_price' => 55000000,
            'selling_price' => 68000000,
            'stock' => 4,
            'description' => 'Tas Saddle ikonik dengan nuansa abu-abu monokrom yang elegan dan modern.'
        ]);
    }
}