<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // DB facade ถูกใช้สำหรับการคำนวณ SUM

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

        // 2. ดึงข้อมูลสินค้าล่าสุด พร้อมคำนวณยอดขายรวม (Total Sold) ของแต่ละชิ้น
        $products = Product::withCount(['orderItems as total_sold' => function ($query) {
            $query->select(DB::raw('sum(quantity)')); 
        }])
        ->orderBy('created_at', 'desc')
        //->take(10) // *** ควรกำหนด take(10) เพื่อจำกัดสินค้าล่าสุด ***
        ->get();

        // 3. คำนวณยอดขายรวมทั้งหมด (Total Items Sold)
        $totalItemsSold = $products->sum('total_sold'); 
        
        // ******************************************************************
        // *** 4. คำนวณรายได้รวม (Total Revenue) ***
        // *** ใช้ price_at_purchase และส่งตัวแปรไปยัง View ***
        // ******************************************************************
        $totalRevenue = DB::table('order_items')
            ->select(DB::raw('SUM(price_at_purchase * quantity) AS total_revenue')) 
            ->value('total_revenue'); 
        // ******************************************************************

        // 5. ส่งข้อมูลทั้งหมดไปที่ View
        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'recentProducts' => $products, // ใช้ชื่อ $recentProducts ตามที่ View คาดหวัง
            'totalItemsSold' => $totalItemsSold, // ยอดรวมจำนวนชิ้นที่ขาย
            'totalRevenue' => $totalRevenue, // *** เพิ่มตัวแปรรายได้รวม ***
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
        $completed_status = 'COMPLETED'; 

        // 1. ตรวจสอบสถานะก่อนเปลี่ยน เพื่อป้องกันการเปลี่ยนซ้ำ
        if ($order->status !== $completed_status) {
            
            // 2. อัปเดตสถานะของคำสั่งซื้อ
            $order->status = $completed_status;
            $order->save();

            // 3. ส่งกลับไปที่หน้ารายการพร้อมข้อความสำเร็จ
            return redirect()->route('admin.orders.index')->with('success', 
                "Order #{$order->id} has been successfully marked as completed.");
        }

        return redirect()->back()->with('error', 
            "Order #{$order->id} is already completed.");
    }
}