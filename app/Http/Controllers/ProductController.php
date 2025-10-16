<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // ต้อง import Category Model
use App\Models\Order;
use Illuminate\Http\Request; // ต้อง import Request
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource with optional category filtering.
     */
    public function index(Request $request) // ต้องรับ Request object
    {
        // 1. ดึง Category ทั้งหมดเพื่อแสดงในตัวกรอง (Filter)
        $categories = Category::all();
        
        // 2. เริ่ม Query สำหรับ Products
        $productsQuery = Product::orderBy('created_at', 'desc');

        // 3. ตรวจสอบว่ามีการส่งพารามิเตอร์ 'category' มาหรือไม่
        $selectedCategory = $request->query('category');
        
        if ($selectedCategory) {
            // 4. ถ้ามี ให้กรองเฉพาะสินค้าใน Category นั้น
            $productsQuery->where('category_id', $selectedCategory);
        }

        // 5. ดึงข้อมูลสินค้าที่ถูกกรอง (หรือทั้งหมด)
        $products = $productsQuery->get();

        // ส่งข้อมูลทั้ง Products และ Categories ไปยัง View
        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }

    /**
     * Display the specified resource.
     * นี่คือส่วนที่เราจะอัปเดต Logic
     */
    public function show(Product $product)
    {
        // *** 1. โหลดความสัมพันธ์ที่จำเป็น: category, reviews และ user ของ review ***
        // *** แก้จาก $product->load('reviews.user') เป็น $product->load('category', 'reviews.user') ***
        // *** เพื่อให้ยังสามารถแสดง Category ใน View ได้ตามที่คุณต้องการก่อนหน้านี้ ***
        $product->load('category', 'reviews.user'); 

        $canReview = false;
        // ตรวจสอบก็ต่อเมื่อผู้ใช้ล็อกอินอยู่เท่านั้น
        if (Auth::check()) {
            $userId = Auth::id();

            // 1. ตรวจสอบว่าเคยสั่งซื้อและสถานะเป็น COMPLETED หรือไม่
            $hasPurchased = Order::where('user_id', $userId)
                ->where('status', 'COMPLETED')
                ->whereHas('items', function ($query) use ($product) {
                    $query->where('product_id', $product->product_id);
                })
                ->exists();

            // 2. ตรวจสอบว่าเคยรีวิวสินค้านี้ไปแล้วหรือยัง
            $hasReviewed = $product->reviews->where('user_id', $userId)->isNotEmpty();

            // จะสามารถรีวิวได้ก็ต่อเมื่อ "เคยซื้อและสถานะ COMPLETED" และ "ยังไม่เคยรีวิว"
            $canReview = $hasPurchased && !$hasReviewed;
        }

        // ส่งตัวแปร $product และ $canReview ไปให้ View เพื่อใช้ในการตัดสินใจว่าจะแสดงฟอร์มหรือไม่
        return view('products.show', compact('product', 'canReview'));
    }


    // ... (ส่วนของ Admin เหมือนเดิม) ...
    
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,category_id',
            // *** อัปเดตตามการใช้ URL ***
            'image_url' => 'nullable|url|max:500', 
        ]);

        // *** อัปเดตตามการใช้ URL: เปลี่ยน $request->except('image') เป็น $request->only(...) ***
        $productData = $request->only(['name', 'description', 'price', 'stock_quantity', 'category_id', 'image_url']);

        Product::create($productData);

        return redirect()->route('admin.dashboard')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,category_id',
            // *** อัปเดตตามการใช้ URL ***
            'image_url' => 'nullable|url|max:500', 
        ]);

        // *** อัปเดตตามการใช้ URL: เปลี่ยน $request->except('image') เป็น $request->only(...) ***
        $productData = $request->only(['name', 'description', 'price', 'stock_quantity', 'category_id', 'image_url']);

        $product->update($productData);

        return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product) 
    {
        // *** 1. ลบ Reviews ทั้งหมดที่เกี่ยวข้องกับสินค้านี้ก่อน ***
        $product->reviews()->delete();
        
        // *** 2. ลบ OrderItems ทั้งหมดที่เกี่ยวข้องกับสินค้านี้ก่อน ***
        // เนื่องจาก OrderItem ไม่มีความสัมพันธ์ on delete cascade เราต้องสั่งลบเอง
        $product->orderItems()->delete(); 
        
        // *** 3. ลบสินค้าหลัก ***
        $product->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully.');
    }
}
