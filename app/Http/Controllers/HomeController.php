<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory; 
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
// use App\Models\Category; // (ลบอันนี้ถ้าไม่ได้ใช้)

class HomeController extends Controller
{

    public function index(Request $request)
    {
        // 1. ดึง Categories ทั้งหมดมา (ใช้ Model 'ProductCategory' ตามโค้ดเดิมของคุณ)
        $categories = ProductCategory::all(); 
        
        // 2. เริ่มสร้าง Query (เพิ่ม latest() และ with() จากโค้ดเดิมของคุณ)
        $productQuery = Product::with('productCategory')->latest(); 

        // 3. ตรวจสอบว่ามี query string 'category' ใน URL หรือไม่
        if ($request->has('category')) {
            $categoryName = $request->query('category');
            
            // 4. ใช้ whereHas กับ relationship 'productCategory' (ตามโค้ดเดิมของคุณ)
            //    (หมายเหตุ: ใน Model Product.php ต้องมีฟังก์ชันชื่อ 'productCategory')
            $productQuery->whereHas('productCategory', function ($query) use ($categoryName) {
                $query->where('name', $categoryName);
            });
        }

        // 5. สั่งให้ Query ทำงาน
        $products = $productQuery->get();

        // 6. ส่ง $products (ที่กรองแล้ว) และ $categories (สำหรับปุ่ม) ไปที่ View
        return view('home', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function myOrders()
    {
        $userId = Auth::id(); // 1. ดึง ID ของคนที่ล็อกอิน

        // 2. ดึง Order ของ User นี้ (เรียงจากใหม่ไปเก่า)
        $orders = \App\Models\Order::where('user_id', $userId)
                                ->with('orderDetails.product')
                                ->latest()
                                ->get();

        // 3. ส่งข้อมูลไปที่ View ใหม่
        return view('my-orders', compact('orders'));
    }

    /**
     * ลูกค้าทำการยกเลิก Order ของตัวเอง
     */
    public function cancelOrder(Request $request, Order $order)
    {
        $userId = Auth::id();

        // 1. [Security Check] ตรวจสอบว่า Order นี้เป็นของ User ที่ login อยู่จริง
        if ($order->user_id != $userId) {
            return redirect()->back()->with('error', 'You are not authorized to perform this action.');
        }

        // 2. [Rule Check] ตรวจสอบว่าสถานะเป็น 'pending' จริง
        if ($order->status == 'pending') {
            // 3. อัปเดตสถานะ
            $order->status = 'cancelled';
            $order->save();

            return redirect()->back()->with('success', 'Order #' . $order->id . ' has been cancelled successfully.');
        }

        // 4. ถ้าสถานะไม่ใช่ 'pending' (เช่น Admin เพิ่งเปลี่ยนเป็น 'processing' ไป)
        return redirect()->back()->with('error', 'This order can no longer be cancelled.');
    }
}
