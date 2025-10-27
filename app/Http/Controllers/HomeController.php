<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลหมวดหมู่ทั้งหมด
        $categories = ProductCategory::all();

        // ดึงข้อมูลสินค้าทั้งหมด (พร้อมรูปภาพและหมวดหมู่)
        $products = Product::with('productCategory')->latest()->get();

        // ส่งข้อมูลไปที่ View
        return view('home', compact('products', 'categories'));
    }
}
