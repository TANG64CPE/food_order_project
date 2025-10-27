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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id(); // ตรงกับ ProductCategoryID
            $table->string('name');
            
            // นี่คือส่วนที่ทำ หมวดหมู่ย่อย (Sub-Category)
            // เชื่อมโยงกับ id ของตารางตัวเอง, อนุญาตให้เป็น null (ถ้าเป็นหมวดหมู่หลัก)
            $table->foreignId('parent_product_category_id')
                ->nullable()
                ->constrained('product_categories')
                ->onDelete('set null'); // ถ้าหมวดแม่ถูกลบ ให้ลูกๆ เป็น null (Top-level)
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
