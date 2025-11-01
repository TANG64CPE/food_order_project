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
        // สั่งให้ "ลบ" ตาราง ถ้ามันมีอยู่
        Schema::dropIfExists('order_items');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // (เผื่อ Rollback) ให้ "สร้าง" ตารางนี้กลับคืนมา
        // (ผมดูโครงสร้างจาก ERD ที่คุณส่งมาให้ครับ)
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }
};