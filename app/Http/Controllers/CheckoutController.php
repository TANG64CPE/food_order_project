<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 1. เพิ่ม Auth
use App\Models\Order;                 // 2. เพิ่ม Order
use App\Models\OrderDetail;            // 3. เพิ่ม OrderDetail
use Illuminate\Support\Facades\DB;      // 4. เพิ่ม DB (สำหรับ Transaction)

class CheckoutController extends Controller
{
    /**
     * แสดงหน้า Checkout
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        // ถ้าตะกร้าว่างเปล่า ให้เด้งกลับไปหน้าตะกร้า
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // ถ้าตะกร้ามีของ ให้ไปหน้า checkout
        return view('checkout');
    }

    /**
     * บันทึก Order ลง Database
     */
    public function store(Request $request)
    {
        // 1. ตรวจสอบข้อมูลฟอร์ม
        $validated = $request->validate([
            // 'shipping_address' => 'required|string',
            
            // (field ใหม่ๆ)
            'shipping_street_address' => 'required|string|max:255',
            'shipping_subdistrict' => 'required|string|max:255',
            'shipping_district' => 'required|string|max:255',
            'shipping_province' => 'required|string|max:255',
            'shipping_postcode' => 'required|string|max:5',
            'shipping_phone' => 'required|string|max:10',
            'payment_method' => 'required|string|in:cash_on_delivery', // ต้องเป็น 'cash_on_delivery' เท่านั้น
        ]);

        // 2. ดึงตะกร้าและ User ที่ล็อกอิน
        $cart = session()->get('cart', []);
        $user = Auth::user();

        // 3. (ป้องกัน) ถ้าตะกร้าว่างเปล่า
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        // 4. คำนวณยอดรวม (Total)
        $totalAmount = 0;
        foreach ($cart as $details) {
            $totalAmount += $details['price'] * $details['quantity'];
        }

        // 5. [สำคัญ] ใช้ DB Transaction
        // เพื่อป้องกันว่า ถ้าบันทึก OrderDetail พลาด Order หลักก็จะไม่ถูกสร้างด้วย
        DB::beginTransaction();

        try {
            // 2. [สำคัญ] รวมที่อยู่ใหม่ให้เป็น string
            $full_address = $validated['shipping_street_address'] . ', ' .
                            'ต.' . $validated['shipping_subdistrict'] . ', ' .
                            'อ.' . $validated['shipping_district'] . ', ' .
                            'จ.' . $validated['shipping_province'] . ' ' .
                            $validated['shipping_postcode'];
        } catch (\Exception $e) {
            // ถ้ามีอะไรพลาด
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to place order. Please try again. Error: ' . $e->getMessage());
        }

        try {
            // 6. สร้าง Order (ใบสั่งซื้อหลัก)
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending', // สถานะ: รอดำเนินการ
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending', // สถานะชำระเงิน: รอดำเนินการ
                'shipping_address' => $full_address,
                'shipping_street_address' => $validated['shipping_street_address'],
                'shipping_subdistrict' => $validated['shipping_subdistrict'],
                'shipping_district' => $validated['shipping_district'],
                'shipping_province' => $validated['shipping_province'],
                'shipping_postcode' => $validated['shipping_postcode'],
                'shipping_phone' => $validated['shipping_phone'],
            ]);

            // 7. สร้าง Order Details (รายการสินค้าในใบสั่งซื้อ)
            foreach ($cart as $productId => $details) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'order_qty' => $details['quantity'],
                    'unit_price' => $details['price'],
                    'line_total' => $details['price'] * $details['quantity'],
                ]);
            }

            // 8. ถ้าทุกอย่างสำเร็จ
            DB::commit();

            // 9. ล้างตะกร้า (Session)
            session()->forget('cart');

            // 10. กลับไปหน้า Home (หรือหน้า Thank You)
            return redirect()->route('home')->with('success', 'Order placed successfully! Thank you for your purchase.');

        } catch (\Exception $e) {
            // 11. ถ้ามีอะไรพลาด
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to place order. Please try again. Error: ' . $e->getMessage());
        }
    }
}