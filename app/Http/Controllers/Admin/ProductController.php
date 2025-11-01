<?php

namespace App\Http\Controllers\Admin;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ดึงข้อมูลสินค้า "พร้อมกับ" ข้อมูลหมวดหมู่ (Eager Loading)
        $products = Product::with('productCategory')->latest()->get();

        // ส่งข้อมูล ($products) ไปยัง view
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ดึงหมวดหมู่ทั้งหมดไปให้ Dropdown
        $categories = ProductCategory::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 4a. ตรวจสอบข้อมูล (Validation)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock_qty' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'product_number' => 'nullable|string|unique:products,product_number',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // 4b. จัดการการอัปโหลดไฟล์รูปภาพ
        if ($request->hasFile('image_url')) {
            // 1. เก็บไฟล์ลงใน 'storage/app/public/products'
            // 2. 'store' จะ return path ของไฟล์ เช่น 'products/filename.jpg'
            $path = $request->file('image_url')->store('products', 'public');
            
            // 3. เก็บ path ที่ได้ ลงใน $validatedData
            $validatedData['image_url'] = $path;
        }

        // 4c. สร้าง Product
        Product::create($validatedData);

        // 4d. กลับไปหน้า index
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) // 1. หา Product ให้เลย
    {
        // ดึงหมวดหมู่ทั้งหมดสำหรับ Dropdown
        $categories = ProductCategory::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // 1. ตรวจสอบข้อมูล
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock_qty' => 'required|integer|min:0',
            'description' => 'nullable|string',
            // ตรวจ unique โดย "ยกเว้น" ID ของตัวเอง
            'product_number' => 'nullable|string|unique:products,product_number,' . $product->id, 
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. จัดการอัปโหลด "รูปใหม่" 
        if ($request->hasFile('image_url')) {

            // 2a. ลบรูปเก่าทิ้งก่อน
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }

            // 2b. อัปโหลดรูปใหม่ และเก็บ path
            $path = $request->file('image_url')->store('products', 'public');
            $validatedData['image_url'] = $path;
        }

        // 3. อัปเดตข้อมูล 
        $product->update($validatedData);

        // 4. กลับไปหน้า index
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // 1. ลบไฟล์รูปภาพออกจาก Storage ก่อน
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        // 2. สั่งลบข้อมูลออกจาก DB
        $product->delete();

        // 3. กลับไปหน้า index
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
