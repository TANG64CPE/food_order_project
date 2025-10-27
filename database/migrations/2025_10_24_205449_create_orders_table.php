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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // ตรงกับ OrderID
            
            // ใครสั่ง
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->dateTime('order_date')->useCurrent(); // ใช้วันที่ปัจจุบัน
            $table->string('status')->default('pending'); // pending, processing, completed, cancelled
            $table->decimal('total_amount', 10, 2);
            
            // รายละเอียดการชำระเงิน (จาก ERD)
            $table->string('payment_method')->nullable(); // e.g., 'cash', 'credit_card'
            $table->string('payment_status')->default('pending'); // e.g., 'pending', 'paid'
            
            // --- ส่วนที่อยู่จัดส่ง (แทนระบบ Address Book) ---
            $table->text('shipping_address');
            $table->string('shipping_phone');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
