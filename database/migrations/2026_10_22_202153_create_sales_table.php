<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->date('sale_date');
            $table->string('customer_name')->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->decimal('paid_amount', 15, 2);
            $table->decimal('change_amount', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};