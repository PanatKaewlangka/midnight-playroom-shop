{{-- resources/views/products/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    
    {{-- โชว์ข้อความ Success/Error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ส่วนแสดงรายละเอียดสินค้าหลัก --}}
    <div class="row mb-5">
        <div class="col-md-5">
            <img src="{{ asset($product->image_url) }}" class="img-fluid" alt="{{ $product->name }}">
        </div>
        <div class="col-md-7">
            <h2>{{ $product->name }}</h2>
            <p class="lead">${{ number_format($product->price, 2) }}</p>

             {{-- *** เพิ่มตรงนี้: แสดง Category *** --}}
            @if ($product->category)
                <p class="text-muted lead">Category: 
                        {{ $product->category->name }}
                </p>
            @endif
            {{-- ************************************ --}}

            <p>{{ $product->description }}</p>

            

            {{-- Form สำหรับ Add to Cart --}}
            <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" style="width: 100px;">
                </div>

                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-cart-plus"></i> Add to Cart 
                </button>
            </form>
            
            <div class="mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            
            {{-- 1. ส่วนแสดงคะแนนเฉลี่ย (Average Rating) --}}
            <div class="mt-4 p-3 border rounded shadow-sm">
                @php 
                    $avgRating = $product->averageRating() ?? 0;
                    $reviewCount = $product->reviews->count();
                @endphp
                <h4 class="mb-0">Customer Reviews ({{ $reviewCount }})</h4>
                <p class="lead">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="bi {{ $i <= round($avgRating) ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                    @endfor
                    <span class="ms-2">**{{ number_format($avgRating, 1) }}** out of 5</span>
                </p>
            </div>

            <hr class="my-4">

            {{-- 2. ฟอร์มสำหรับส่ง Review ใหม่ (สำหรับ Verified Buyer) --}}
            @auth
                {{-- ตรวจสอบว่าเคยรีวิวแล้วหรือไม่ --}}
                @php
                    $hasReviewed = $product->reviews->where('user_id', Auth::id())->isNotEmpty();
                    // $canReview มาจาก ProductController@show
                @endphp
                
                @if ($hasReviewed)
                    <div class="alert alert-info">You have already submitted a review for this product.</div>
                @elseif (isset($canReview) && $canReview)
                    {{-- แสดงฟอร์มก็ต่อเมื่อ $canReview เป็น TRUE (Verified Buyer) --}}
                    <div class="mb-5 p-4 border rounded">
                        <h5 class="mb-3">Submit Your Review</h5>
                        
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                            {{-- ส่วน Rating Star Clicker --}}
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating (1-5)</label>
                                
                                <div id="star-rating-area" class="d-flex align-items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star me-1 rating-star" 
                                           data-rating="{{ $i }}" 
                                           style="font-size: 1.5rem; cursor: pointer; color: #ced4da;"></i> 
                                    @endfor
                                </div>
                                
                                {{-- Input Field ที่ซ่อนอยู่สำหรับส่งค่าคะแนนจริง --}}
                                <input type="hidden" name="rating" id="rating-input" required>
                                
                                @error('rating') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            
                            {{-- ส่วน Comment --}}
                            <div class="mb-3">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                                @error('comment') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Post Review</button>
                        </form>
                    </div>
                @else
                    {{-- ถ้าล็อกอินแล้ว แต่ยังรีวิวไม่ได้ (Order ยังไม่ COMPLETED) --}}
                    <div class="alert alert-info">
                        Thank you for being a member! Reviews can only be submitted by **verified buyers** whose order status is **COMPLETED**.
                    </div>
                @endif
            @else
                <div class="alert alert-warning">
                    Please <a href="{{ route('login') }}">log in</a> to post a review.
                </div>
            @endauth

            <hr class="my-4">

            {{-- 3. รายการแสดง Review ทั้งหมด --}}
            <h4 class="mb-3">All Customer Reviews ({{ $reviewCount }})</h4>
            
            <div class="list-group">
                @foreach($product->reviews->sortByDesc('created_at') as $review)
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">{{ $review->user->name ?? 'Guest User' }}</h6>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                    
                    {{-- Rating Stars --}}
                    <p class="mb-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $review->rating ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                        @endfor
                    </p>
                    
                    {{-- Comment --}}
                    <p class="mb-1">{{ $review->comment }}</p>
                    
                    {{-- ปุ่มแก้ไข/ลบ --}}
                    @auth
                        @if (Auth::id() === $review->user_id)
                            <div class="mt-2">
                                <form action="{{ route('reviews.destroy', $review->review_id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Are you sure you want to delete your review?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                                <button type="button" class="btn btn-info btn-sm text-white" 
                                        data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $review->review_id }}" 
                                        data-review-id="{{ $review->review_id }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </div>
                        @endif
                    @endauth
                </div>
                @endforeach
            </div>
            
        </div>
    </div>
</div>
@endsection


{{-- Modal สำหรับแก้ไข Review --}}
@auth
    @foreach($product->reviews->where('user_id', Auth::id()) as $review)
    <div class="modal fade" id="editReviewModal{{ $review->review_id }}" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- FORM START --}}
                <form action="{{ route('reviews.update', $review->review_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- MODAL HEADER --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editReviewModalLabel">Edit Your Review for {{ $product->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    {{-- MODAL BODY (แก้แล้ว) --}}
                    <div class="modal-body">
                        
                        {{-- 1. ส่วน Rating (ดาว) --}}
                        <div class="mb-3">
                            <label for="modal-rating-{{ $review->review_id }}" class="form-label">Rating (1-5)</label>
                            
                            <div id="modal-star-rating-area-{{ $review->review_id }}" 
                                 class="d-flex align-items-center modal-rating-area" 
                                 data-initial-rating="{{ $review->rating }}">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi me-1 rating-star-modal" 
                                       data-rating="{{ $i }}" 
                                       style="font-size: 1.5rem; cursor: pointer; color: #ced4da;"></i> 
                                @endfor
                            </div>
                            
                            <input type="hidden" name="rating" id="modal-rating-input-{{ $review->review_id }}" value="{{ $review->rating }}" required>
                        </div>

                        {{-- 2. ส่วน Comment --}}
                        <div class="mb-3">
                            <label for="edit_comment_{{ $review->review_id }}" class="form-label">Comment</label>
                            <textarea name="comment" 
                                      id="edit_comment_{{ $review->review_id }}" 
                                      class="form-control" 
                                      rows="3" required>{{ $review->comment }}</textarea>
                        </div>
                        
                    </div>

                    {{-- MODAL FOOTER (แก้แล้ว) --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button> 
                    </div>

                </form>
                {{-- FORM END --}}
            </div>
        </div>
    </div>
    @endforeach
@endauth

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // --- ฟังก์ชันหลักสำหรับอัปเดตสถานะดาว (ใช้ได้ทั้งฟอร์มใหม่และ Modal) ---
        function updateStarDisplay(area, rating, selectorClass) {
            area.querySelectorAll(selectorClass).forEach(function(star) {
                const starValue = parseInt(star.dataset.rating);
                if (starValue <= rating) {
                    star.classList.remove('bi-star', 'text-muted');
                    star.classList.add('bi-star-fill', 'text-warning');
                } else {
                    star.classList.remove('bi-star-fill', 'text-warning');
                    star.classList.add('bi-star', 'text-muted');
                }
            });
        }
        
        // --- 1. Logic สำหรับฟอร์มส่ง Review ใหม่ (New Review Form) ---
        const ratingArea = document.getElementById('star-rating-area');
        const ratingInput = document.getElementById('rating-input');
        let selectedRating = ratingInput ? parseInt(ratingInput.value) || 0 : 0;
        
        if (ratingArea) {
            updateStarDisplay(ratingArea, selectedRating, '.rating-star'); // แสดงผลดาวเริ่มต้น

            // Event Listeners สำหรับ Hover (ต้องผูกกับ Element โดยตรง)
            ratingArea.querySelectorAll('.rating-star').forEach(star => {
                star.addEventListener('mouseenter', function() {
                    updateStarDisplay(ratingArea, parseInt(this.dataset.rating), '.rating-star');
                });
                star.addEventListener('mouseleave', function() {
                    updateStarDisplay(ratingArea, selectedRating, '.rating-star');
                });
                star.addEventListener('click', function() {
                    selectedRating = parseInt(this.dataset.rating);
                    ratingInput.value = selectedRating;
                    updateStarDisplay(ratingArea, selectedRating, '.rating-star');
                });
            });

            // ป้องกันการส่งฟอร์มถ้าคะแนนเป็น 0
            ratingArea.closest('form').addEventListener('submit', function(e) {
                if (selectedRating === 0) {
                    e.preventDefault();
                    // เปลี่ยนจาก alert() เป็นการแสดงผลข้อความใน UI แทน (ตามหลักการ Canvas)
                    // เนื่องจากไม่มี UI สำหรับแสดง error ตรงนี้ ผมจะใช้ console.error แทน 
                    console.error('Please select a star rating before submitting your review.');
                }
            });
        }


        // --- 2. Logic สำหรับ Modal แก้ไข (Edit Review Modal) ---
        // 2.1. Event Delegation: Click ใน Modal (บันทึกค่าคะแนน)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('rating-star-modal')) {
                const clickedStar = e.target;
                const clickedRating = parseInt(clickedStar.dataset.rating);

                // 1. หา Element ที่เป็น Modal Body ที่อยู่ใกล้ที่สุด
                const modalBody = clickedStar.closest('.modal-body'); 
                
                if (modalBody) {
                    // 2. ค้นหา Input Field ที่ซ่อนอยู่ ที่มี name="rating" ภายใน Modal Body นั้น (แก้ปัญหา Rating ไม่เปลี่ยน)
                    const ratingInput = modalBody.querySelector('input[name="rating"]');

                    if (ratingInput) {
                        // 3. กำหนดค่าใหม่ให้ Input Field นี้
                        ratingInput.value = clickedRating; 
                        
                        // อัปเดตการแสดงผลดาว
                        const modalArea = clickedStar.closest('.modal-rating-area');
                        if (modalArea) {
                            updateStarDisplay(modalArea, clickedRating, '.rating-star-modal');
                        }
                    }
                }
            }
        });
        
        // 2.2. Event Delegation: Hover ใน Modal (เมื่อวางเมาส์)
        document.addEventListener('mouseover', function(e) {
            if (e.target.classList.contains('rating-star-modal')) {
                const modalArea = e.target.closest('.modal-rating-area');
                const hoverRating = parseInt(e.target.dataset.rating);
                updateStarDisplay(modalArea, hoverRating, '.rating-star-modal');
            }
        });
        
        // 2.3. Event Delegation: Mouseout ใน Modal (เมื่อออกจากดาว)
        document.addEventListener('mouseout', function(e) {
            if (e.target.classList.contains('rating-star-modal')) {
                const modalArea = e.target.closest('.modal-rating-area');
                const currentModalRating = parseInt(modalArea.querySelector('input[name="rating"]').value); // แก้ให้ค้นหาตาม name="rating"
                updateStarDisplay(modalArea, currentModalRating, '.rating-star-modal');
            }
        });

        // 2.4. ตั้งค่าดาวเริ่มต้นใน Modal ตอนที่ Modal ถูก Render (สำหรับดาวที่แสดงผล)
        document.querySelectorAll('.modal-rating-area').forEach(function(area) {
            const initialRating = parseInt(area.dataset.initialRating);
            updateStarDisplay(area, initialRating, '.rating-star-modal');
        });
    });
</script>
@endsection
