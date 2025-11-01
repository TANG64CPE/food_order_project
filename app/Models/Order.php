<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'shipping_address',
        'shipping_phone',
        // (field อื่นๆ ของคุณที่เคยเพิ่มไว้)
        'shipping_street_address',
        'shipping_subdistrict',
        'shipping_district',
        'shipping_province',
        'shipping_postcode',
    ];

    /**
     * สร้างความสัมพันธ์: หนึ่ง Order มีหลาย OrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // ในไฟล์ app/Models/Order.php

    public function orderDetails()
    {
        // ลบ App\Models\ ที่อยู่ข้างหน้าออก
        return $this->hasMany(OrderDetail::class); 
    }

    /**
     * สร้างความสัมพันธ์: หนึ่ง Order เป็นของ User หนึ่งคน
     * (นี่คือฟังก์ชันที่คุณต้องเพิ่ม)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // ชื่อฟังก์ชัน (user) ต้องตรงกับที่ Controller เรียกใช้
        return $this->belongsTo(User::class);
    }
}