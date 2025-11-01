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
        Schema::table('orders', function (Blueprint $table) {
            // เราจะเพิ่มคอลัมน์ใหม่สำหรับที่อยู่
            // เราตั้งให้ nullable() เพื่อความปลอดภัย และไม่ให้กระทบออเดอร์เก่า
            $table->string('shipping_street_address')->nullable()->after('shipping_phone');
            $table->string('shipping_subdistrict')->nullable()->after('shipping_street_address');
            $table->string('shipping_district')->nullable()->after('shipping_subdistrict');
            $table->string('shipping_province')->nullable()->after('shipping_district');
            $table->string('shipping_postcode')->nullable()->after('shipping_province');

            // (ทางเลือก) ทำให้คอลัมน์ 'shipping_address' (อันเก่า) สามารถเป็นค่าว่างได้
            $table->text('shipping_address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     * (ฟังก์ชันนี้ต้องอยู่ "ข้างใน" class)
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_street_address',
                'shipping_subdistrict',
                'shipping_district',
                'shipping_province',
                'shipping_postcode'
            ]);

            // (ทางเลือก) เอากลับไปเป็น NOT NULL
            $table->text('shipping_address')->nullable(false)->change();
        });
    }
}; 
