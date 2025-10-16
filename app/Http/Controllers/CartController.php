<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);
        
        // คำนวณยอดรวมใน Controller
        $total = collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // ส่งข้อมูลไปให้ View
        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->product_id])) {
            $cart[$product->product_id]['quantity']++;
        } else {
            $cart[$product->product_id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image_url" => $product->image_url
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Update product quantity in the cart.
     */
    public function update(Request $request)
    {
        if ($request->product_id && $request->quantity > 0) {
            $cart = session()->get('cart');
            $cart[$request->product_id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Cart updated successfully.');
        }
        return back()->with('error', 'Unable to update cart.');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Request $request)
    {
        if ($request->product_id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->product_id])) {
                unset($cart[$request->product_id]);
                session()->put('cart', $cart);
                return back()->with('success', 'Product removed from cart.');
            }
        }
        return back()->with('error', 'Product not found in cart.');
    }
}

