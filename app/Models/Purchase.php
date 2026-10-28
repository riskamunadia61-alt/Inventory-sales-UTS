<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relasi ke Supplier / Pemasok
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}