<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * แสดงออเดอร์ทั้งหมดในหน้า Admin
     */
    public function index()
    {
        // ดึงออเดอร์ทั้งหมด (เรียงจากใหม่ไปเก่า)
        // .with('user') เพื่อดึงชื่อคนสั่ง (Eager Loading)
        $orders = Order::with('user')->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * แสดงรายละเอียดของออเดอร์เดียว
     */
    public function show(Order $order)
    {
        // โหลดข้อมูลที่เกี่ยวข้องทั้งหมดสำหรับออเดอร์นี้
        // 1. user (คนสั่ง)
        // 2. orderDetails (รายการสินค้า)
        // 3. orderDetails.product (ข้อมูลสินค้าในรายการ)
        $order->load(['user', 'orderDetails.product']);

        // ส่งข้อมูล $order ก้อนนี้ (ที่มีทุกอย่าง) ไปที่ View ใหม่
        return view('admin.orders.show', compact('order'));
    }
    
    /**
     * อัปเดตสถานะออเดอร์
     */
    public function update(Request $request, Order $order)
    {
        // 1. ตรวจสอบข้อมูลที่ส่งมา
        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
        ]);

        // 2. อัปเดตสถานะของ Order นั้นๆ
        $order->status = $validated['status'];
        $order->save();

        // 3. กลับไปหน้าเดิม พร้อมข้อความ success
        return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully.');
    }
}
