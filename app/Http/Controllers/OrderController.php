<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders (Order History).
     */
    public function index()
    {
        // 1. ดึง ID ของผู้ใช้ที่ล็อกอินอยู่
        $userId = Auth::id();

        // 2. ดึงรายการคำสั่งซื้อทั้งหมดของ User นี้ 
        // พร้อมโหลดความสัมพันธ์ items (OrderItems) และ product (จาก OrderItem)
        // เพื่อให้แสดงรายละเอียดสินค้าในแต่ละ Order ได้
        $orders = Order::where('user_id', $userId)
                       ->with('items.product') // โหลดความสัมพันธ์ items และ product
                       ->orderBy('order_id', 'desc') // เรียงลำดับจาก Order ล่าสุด
                       ->get();

        // 3. ส่งข้อมูลไปยัง View
        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order detail. (จะทำในขั้นตอนต่อไป)
     */
    public function show(Order $order)
    {
        // ตรวจสอบว่าเป็น Order ของ User ที่ล็อกอินอยู่จริงหรือไม่
        if (Auth::id() !== $order->user_id) {
            abort(403); // หรือ redirect กลับไป
        }
        
        // โหลดรายละเอียดสินค้าและส่งไปที่ view
        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Customer action to set an order status to COMPLETED after receiving.
     */
    public function confirmDelivery(string $order_id)
    {
        // 1. ค้นหา Order โดยใช้ Primary Key 'order_id'
        $order = Order::where('order_id', $order_id)
                      ->where('user_id', Auth::id()) // *** ตรวจสอบว่าเป็น Order ของ User นี้เท่านั้น ***
                      ->first();

        if (!$order) {
            return back()->with('error', 'Order not found or you do not have permission.');
        }

        // 2. ตรวจสอบสถานะ: อนุญาตให้เปลี่ยนเป็น COMPLETED ได้จากสถานะ PENDING หรือ SHIPPED เท่านั้น
        if ($order->status === 'COMPLETED') {
            return back()->with('error', 'This order is already marked as COMPLETED.');
        }
        
        // ถ้าสถานะเป็น PENDING อาจจะตั้งให้เปลี่ยนเป็น SHIPPED ก่อน หรือตรงไป COMPLETED เลย
        // สำหรับวัตถุประสงค์นี้ เราจะอนุญาตให้เปลี่ยนเป็น COMPLETED ได้เลย
        
        // 3. เปลี่ยนสถานะเป็น COMPLETED
        $order->status = 'COMPLETED';
        $order->save();

        // 4. แจ้งเตือนลูกค้าและเปลี่ยนไปรีวิวได้
        return redirect()->route('orders.show', $order_id)->with('success', 'Thank you! Order #' . $order_id . ' status updated to COMPLETED. You can now leave a review.');
    }
}