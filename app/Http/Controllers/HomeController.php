<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

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

    public function myOrders()
    {
        $userId = Auth::id(); // 1. ดึง ID ของคนที่ล็อกอิน

        // 2. ดึง Order ของ User นี้ (เรียงจากใหม่ไปเก่า)
        // .with('orderDetails.product') คือ Eager Loading ขั้นสูง
        // มันจะดึง "ใบสั่งซื้อ" พร้อม "รายการสินค้า" และ "ข้อมูลสินค้า" ในทีเดียว
        $orders = \App\Models\Order::where('user_id', $userId)
                                ->with('orderDetails.product')
                                ->latest()
                                ->get();

        // 3. ส่งข้อมูลไปที่ View ใหม่
        return view('my-orders', compact('orders'));
    }
}
