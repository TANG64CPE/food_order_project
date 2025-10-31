<?php
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Route::get('/', function () {
//     return view('welcome');
// });

// นี่คือของใหม่ที่ชี้ไปที่ Controller ของเรา
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

// ===== CART ROUTES =====
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');

// ===== ADMIN ROUTES =====
// กลุ่มของ Route ทั้งหมดนี้ ต้อง (1) ล็อกอินก่อน และ (2) ต้องเป็น Admin
Route::middleware(['auth', 'admin'])->group(function () {
    
    // สร้าง Dashboard ของ Admin (ชั่วคราว)
    Route::get('/admin/dashboard', function () {
        return 'Welcome Admin!'; // เดี๋ยวเราค่อยสร้างหน้านี้
    })->name('admin.dashboard');

    // สร้าง Route สำหรับ CRUD ทั้งหมดอัตโนมัติ
    Route::resource('/admin/categories', ProductCategoryController::class);
    Route::resource('/admin/products', ProductController::class);
    
});

require __DIR__.'/auth.php';
