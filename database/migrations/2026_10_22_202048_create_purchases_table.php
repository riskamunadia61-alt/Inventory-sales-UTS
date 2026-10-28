<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_number')->unique();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Ditambahkan
            $table->integer('quantity'); // Ditambahkan
            $table->decimal('purchase_price', 15, 2); // Ditambahkan
            $table->date('purchase_date');
            $table->decimal('total_amount', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};