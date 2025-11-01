<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ดึงข้อมูลหมวดหมู่ทั้งหมด เรียงจากใหม่ไปเก่า
        $categories = ProductCategory::latest()->get();

        // ส่งข้อมูล ($categories) ไปยัง view
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ดึงหมวดหมู่ทั้งหมด เพื่อไปทำ Dropdown 
        $categories = ProductCategory::all();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. ตรวจสอบข้อมูล (Validation)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:product_categories',
            'parent_product_category_id' => 'nullable|exists:product_categories,id'
        ]);

        // 2. สร้างและบันทึกข้อมูล
        ProductCategory::create($validatedData);

        // 3. กลับไปหน้า index พร้อมข้อความ success
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
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
    public function edit(ProductCategory $category) // 1. เราใช้ Route Model Binding (มันหา $category ให้เราอัตโนมัติจาก ID)
    {
        // ดึงหมวดหมู่ทั้งหมด 
        // ยกเว้น "ตัวเอง" 
        $categories = ProductCategory::where('id', '!=', $category->id)->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $category)
    {
        // 1. ตรวจสอบข้อมูล
        $validatedData = $request->validate([
            // ต้องเช็ก unique โดย "ยกเว้น" ID ของตัวเอง
            'name' => 'required|string|max:255|unique:product_categories,name,' . $category->id,
            'parent_product_category_id' => 'nullable|exists:product_categories,id'
        ]);

        // 2. อัปเดตข้อมูล
        $category->update($validatedData);

        // 3. กลับไปหน้า index
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {
        // (เราอาจจะเพิ่มโลจิกตรวจสอบก่อนลบทีหลัง เช่น ถ้ามีสินค้าในหมวดนี้ ห้ามลบ)

        // 1. สั่งลบ
        $category->delete();

        // 2. กลับไปหน้า index
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
