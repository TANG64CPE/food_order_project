<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',     // ตัวที่คุณเพิ่มไปรอบที่แล้ว
        'product_id',   // (น่าจะมีตัวนี้อยู่แล้ว)
        'order_qty',    // <-- เพิ่มตัวนี้เข้าไป
        'unit_price',
        "line_total" ,       // (คุณอาจจะต้องเพิ่มตัวนี้ด้วย ถ้ามี)
        // ฯลฯ (เพิ่มทุก field ที่คุณต้องการบันทึก)
    ];
    /**
     * สร้างความสัมพันธ์: หนึ่ง OrderDetail เป็นของ Product หนึ่งชิ้น
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        // ชื่อฟังก์ชัน (product) ต้องตรงกับที่ Controller เรียกใช้
        // และเราสันนิษฐานว่า Model สินค้าของคุณคือ App\Models\Product
        return $this->belongsTo(Product::class);
    }

    /**
     * (แนะนำ) เพิ่มความสัมพันธ์กลับไปยัง Order ด้วย
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}