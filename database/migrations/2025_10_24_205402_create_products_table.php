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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // ตรงกับ ProductID
            $table->string('name');
            $table->string('product_number')->nullable()->unique(); // SKU
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('price', 8, 2); // ราคา
            $table->integer('stock_qty')->default(0); // จำนวนสต็อก (ดีมาก!)
            
            // เชื่อมโยงกับตาราง product_categories
            $table->foreignId('product_category_id')
                ->constrained('product_categories')
                ->onDelete('cascade'); // ถ้าหมวดหมู่ถูกลบ ให้ลบสินค้าในหมวดนั้นด้วย
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
