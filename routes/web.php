<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ประตูทางออกฉุกเฉิน (Emergency Logout) ---
Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/')->with('status', 'You have been successfully logged out!');
});


// --- 1. เส้นทางสำหรับบุคคลทั่วไป (Public Routes) ---
// FIX: แยก Route / และ /home ออกจากกันเพื่อให้ตั้งชื่อ Route ได้อย่างถูกต้อง
Route::get('/', [HomeController::class, 'index'])->name('home'); // หน้าหลัก (/)
Route::get('/home', [HomeController::class, 'index']); // สำหรับการเข้าถึงตรงจาก Navbar (/home)

Route::resource('products', ProductController::class)->only(['index', 'show']);

// --- 2. เส้นทางสำหรับจัดการรถเข็น ---
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// --- 3. เส้นทางสำหรับระบบสมาชิก ---
// FIX: ป้องกันไม่ให้ Auth::routes() สร้าง Route /home ซ้ำ
Auth::routes(['home' => false]); 

// --- 4. เส้นทางสำหรับสมาชิกที่ล็อกอินแล้วเท่านั้น ---
Route::middleware(['auth'])->group(function () {
    // ลบ Route /home ที่ซ้ำซ้อนออกไปแล้ว

    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place_order');
    Route::resource('orders', OrderController::class)->only(['index', 'show']);
    Route::resource('reviews', ReviewController::class)->only(['store', 'update', 'destroy']);

    // *** นี่คือเส้นทางที่เราเพิ่มกลับเข้ามา ***
    Route::post('orders/confirm/{order}', [OrderController::class, 'confirmDelivery'])->name('customer.order.confirm');
});


// --- 5. เส้นทางสำหรับ Admin เท่านั้น ---
Route::middleware(['auth' , 'can:is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    
    // **********************************************
    // *** FIX: เพิ่ม Route สำหรับการทำเครื่องหมายว่าเสร็จสิ้น ***
    // **********************************************
    Route::post('orders/{order}/complete', [AdminController::class, 'completeOrder'])
             ->name('order.complete'); // Route name: admin.order.complete

    Route::get('orders', [AdminController::class, 'ordersIndex'])->name('orders.index');
    Route::get('orders/{order}', [AdminController::class, 'orderShow'])->name('orders.show');
});
