<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id(); // ตรงกับ OrderDetailID
            
            // เชื่อมโยงกับตาราง orders
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            // เชื่อมโยงกับตาราง products
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            $table->integer('order_qty');
            $table->decimal('unit_price', 8, 2); // ราคาต่อชิ้น (ณ ตอนที่ซื้อ)
            $table->decimal('line_total', 10, 2); // (Qty * UnitPrice)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
