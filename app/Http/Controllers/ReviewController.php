<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. ตรวจสอบความถูกต้องของข้อมูลที่ส่งมา
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        // --- 2. ตรวจสอบ "Verified Buyer" ---
        // ตรวจสอบว่าผู้ใช้เคยสั่งซื้อสินค้านี้ และสถานะเป็น COMPLETED หรือไม่
        $hasPurchased = Order::where('user_id', $userId)
            ->where('status', 'COMPLETED')
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();

        // ถ้าไม่เข้าเงื่อนไข ให้ส่งกลับพร้อมข้อความ Error
        if (!$hasPurchased) {
            return back()->with('error', 'Only customers who have purchased this product can leave a review.');
        }

        // --- 3. ตรวจสอบการรีวิวซ้ำ ---
        // ป้องกันไม่ให้ผู้ใช้คนเดิมรีวิวสินค้าชิ้นเดิมซ้ำสอง
        $existingReview = Review::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        // --- 4. บันทึกรีวิวลงฐานข้อมูล ---
        Review::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // ส่งกลับไปหน้าเดิมพร้อมข้อความ Success
        return back()->with('success', 'Your review has been submitted successfully!');
    }

    /**
     * Update the specified review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Review $review)
    {
        // *** แก้ไข: เปลี่ยนจาก $this->authorize('update', $review); ไปเป็นการตรวจสอบ ID โดยตรง ***
        if (Auth::id() !== $review->user_id) {
            abort(403, 'You can only edit your own review.'); 
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // แก้ปัญหา Rating ไม่เปลี่ยน
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->save(); 
        
        return back()->with('success', 'Your review has been updated.');
    }

    /**
     * Remove the specified review from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Review $review)
    {
        // ตรวจสอบสิทธิ์: ต้องเป็นเจ้าของรีวิวเท่านั้น
        $this->authorize('delete', $review);

        $review->delete();

        return back()->with('success', 'Your review has been deleted.');
    }
}
