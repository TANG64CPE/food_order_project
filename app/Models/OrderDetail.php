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
        'order_id',     
        'product_id',   
        'order_qty',    
        'unit_price',
        "line_total" ,     
        //เพิ่มทุก field ที่คุณต้องการบันทึก
    ];
    /**
     * สร้างความสัมพันธ์: หนึ่ง OrderDetail เป็นของ Product หนึ่งชิ้น
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        // ชื่อฟังก์ชัน (product) ต้องตรงกับที่ Controller เรียกใช้
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