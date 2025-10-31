<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * แสดงหน้าตะกร้าสินค้า
     */
    public function index()
    {
        // View 'cart.blade.php' จะดึงข้อมูลจาก session() โดยตรง
        // เราแค่ return view ก็พอ
        return view('cart');
    }

    /**
     * เพิ่มสินค้าลงในตะกร้า (Session)
     */
    public function add(Request $request, Product $product)
    {
        // (โค้ดเดิมจากครั้งที่แล้ว)
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image_url" => $product->image_url
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * อัปเดตจำนวนสินค้าในตะกร้า
     */
    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart');

        // ตรวจสอบว่ามีสินค้า และจำนวนที่ส่งมา > 0
        if (isset($cart[$productId]) && $request->quantity > 0) {
            $cart[$productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully.');
        }

        // ถ้าใส่จำนวน 0 หรือแปลกๆ
        return redirect()->back()->with('error', 'Invalid quantity.');
    }

    /**
     * ลบสินค้าออกจากตะกร้า
     */
    public function remove(Request $request, $productId)
    {
        $cart = session()->get('cart');

        if (isset($cart[$productId])) {
            // ลบ key นั้นออกจาก array
            unset($cart[$productId]);
            // บันทึก array ที่อัปเดตแล้วกลับ session
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Product removed successfully.');
        }

        return redirect()->back()->with('error', 'Product not found.');
    }
}