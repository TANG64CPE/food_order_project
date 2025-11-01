<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Product extends Model
{
    protected $fillable = [
            'name',
            'product_number',
            'description',
            'image_url',
            'price',
            'stock_qty',
            'product_category_id',
        ];

    public function productCategory(): BelongsTo
    {
        // สินค้า 1 ชิ้น จะอยู่ใน 1 หมวดหมู่
        return $this->belongsTo(ProductCategory::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
