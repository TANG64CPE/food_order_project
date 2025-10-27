<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    // เพิ่มส่วนนี้เข้าไป
    protected $fillable = [
        'name',
        'parent_product_category_id',
    ];
}
