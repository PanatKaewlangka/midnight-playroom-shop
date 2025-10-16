<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; // ⬅️ 1. ต้องเพิ่ม Product Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $total = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'phone' => 'required|string|max:20',
        ]);

        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }
        
        // ⚡️ ตรวจสอบ Stock ก่อนเริ่ม Transaction
        foreach ($cartItems as $productId => $details) {
            $product = Product::find($productId);
            // ตรวจสอบว่าสินค้ามีอยู่และ Stock พอหรือไม่
            if (!$product || $product->stock_quantity < $details['quantity']) {
                $productName = $product ? $product->name : 'Item';
                return back()->with('error', "Sorry, {$productName} is out of stock or you requested too many. Available stock: " . ($product ? $product->stock_quantity : 0));
            }
        }
        // ⚡️ จบการตรวจสอบ Stock ก่อนเริ่ม Transaction

        try {
            DB::transaction(function () use ($cartItems, $request) {
                $total = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);

                $shippingDetails = [
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => Auth::user()->email,
                ];

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_amount' => $total,
                    'status' => 'PENDING',
                    'shipping_address_snapshot' => json_encode($shippingDetails),
                ]);

                foreach ($cartItems as $productId => $details) {
                    // 1. สร้าง OrderItem
                    OrderItem::create([
                        'order_id' => $order->order_id,
                        'product_id' => $productId,
                        'quantity' => $details['quantity'],
                        'price_at_purchase' => $details['price'],
                    ]);
                    
                    // 2. ⚡️ สำคัญ: ลด Stock สินค้า ⚡️
                    // เนื่องจากเราตรวจสอบ Stock ก่อนหน้าแล้ว จึงมั่นใจว่าสามารถหา Product ได้
                    // การเรียก find ใน transaction อาจจะทำให้เกิด Race Condition ได้
                    // แต่เนื่องจากเรามีการ lock database ผ่าน DB::transaction อยู่แล้ว และเราเรียก findByPk
                    // ในกรณีนี้จึงใช้ได้ แต่การใช้ Decrment มีความปลอดภัยสูง
                    
                    Product::where('product_id', $productId)
                        ->decrement('stock_quantity', $details['quantity']);
                }
            });
        } catch (\Exception $e) {
            // หากเกิด error ใดๆ ใน transaction ข้อมูลจะถูก Rollback (ยกเลิก) ทั้งหมด
            Log::error('Order Placement Failed: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while placing your order. Please try again.');
        }

        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Thank you! Your order has been placed successfully.');
    }
}