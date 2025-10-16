<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // เพิ่มมาจากการ merge

class AdminController extends Controller
{
    /**
     * แสดงหน้า Admin Dashboard พร้อมข้อมูลสรุป
     */
    public function index()
    {
        // 1. นับจำนวนข้อมูลทั้งหมด
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'PENDING')->count();

        // 2. ดึงข้อมูลสินค้า 5 รายการล่าสุด
        $recentProducts = Product::orderBy('created_at', 'desc')->get();

        // 3. ส่งข้อมูลทั้งหมดไปที่ View
        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'recentProducts' => $recentProducts,
        ]);
    }

    /**
     * แสดงรายการ Orders ทั้งหมดสำหรับ Admin
     */
    public function ordersIndex()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * แสดงรายละเอียด Order สำหรับ Admin
     */
    public function orderShow(Order $order)
    {
        // eager load items and their associated product
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Mark a specific order as completed by an admin.
     */
    public function completeOrder(Request $request, Order $order)
    {
        // ใน view เราใช้สถานะ 'COMPLETED' (ตัวพิมพ์ใหญ่)
        // แต่ใน Controller เดิมใช้ 'completed' (ตัวพิมพ์เล็ก)
        // ปรับให้ตรงกันเพื่อความสอดคล้อง
        $completed_status = 'COMPLETED'; 

        // 1. ตรวจสอบสถานะก่อนเปลี่ยน เพื่อป้องกันการเปลี่ยนซ้ำ
        if ($order->status !== $completed_status) {
            
            // 2. อัปเดตสถานะของคำสั่งซื้อ
            $order->status = $completed_status;
            // $order->completed_at = now(); // บันทึกเวลาที่เสร็จสิ้น (ถูกคอมเมนต์ออกชั่วคราวเพื่อแก้ไข Error 1054: Unknown column 'completed_at')
            $order->save();

            // 3. ส่งกลับไปที่หน้ารายการพร้อมข้อความสำเร็จ
            return redirect()->route('admin.orders.index')->with('success', 
                "Order #{$order->id} has been successfully marked as completed.");
        }

        return redirect()->back()->with('error', 
            "Order #{$order->id} is already completed.");
    }
}
