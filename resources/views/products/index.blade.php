@extends('layouts.app')

@section('content')

<div class="container">
    <h1><i class="bi bi-tag-fill me-2"></i> All Playmates</h1>

    {{-- Search Bar and Filter Dropdown Section --}}
    <div class="row mb-4 align-items-center">
        
        {{-- 1. Search Bar (ช่องค้นหา) --}}
        <div class="col-lg-6 col-md-12 mb-3 mb-lg-0">
            <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                <input type="text" 
                       name="q" 
                       class="form-control me-2" 
                       placeholder="Search product name..." 
                       value="{{ $searchQuery ?? '' }}" {{-- แสดงค่าค้นหาเดิม --}}
                >
                {{-- ส่งค่า category ที่ถูกเลือกไปพร้อมกับคำค้นหา --}}
                @if ($selectedCategory)
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                @endif
                <button type="submit" class="btn btn-dark">
                    <i class="bi bi-search"></i>
                </button>
                
                {{-- ปุ่มล้างการค้นหา ถ้ามีการค้นหาอยู่ --}}
                @if ($searchQuery || $selectedCategory)
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                @endif
            </form>
        </div>

        {{-- 2. Filter Dropdown --}}
        <div class="col-lg-6 col-md-12 d-flex justify-content-lg-end justify-content-start">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if ($selectedCategory)
                        {{-- แสดงชื่อ Category ที่ถูกเลือก --}}
                        Category: {{ $categories->firstWhere('category_id', $selectedCategory)->name }}
                    @else
                        All Categories
                    @endif
                </button>
                <ul class="dropdown-menu">
                    {{-- ลิงก์สำหรับแสดงสินค้าทั้งหมด --}}
                    <li>
                        <a class="dropdown-item @unless($selectedCategory) active @endunless"
                            href="{{ route('products.index', ['q' => $searchQuery ?? null]) }}">
                            All Playmates
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    @foreach ($categories as $category)
                        <li>
                            <a class="dropdown-item @if($selectedCategory == $category->category_id) active @endif"
                                href="{{ route('products.index', ['category' => $category->category_id, 'q' => $searchQuery ?? null]) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    {{-- End Search and Filter Section --}}

    
    <div class="row">
        @forelse ($products as $product)
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="row g-0">
                    {{-- รูปภาพด้านซ้าย (30%) --}}
                    <div class="col-md-3">
                        <img src="{{ $product->image_url }}"
                             class="img-fluid rounded-start w-100 h-100 object-fit-cover"
                             alt="{{ $product->name }}"
                             style="max-height: 250px; min-height: 200px;"> {{-- ปรับ min-height เพื่อความสม่ำเสมอ --}}
                    </div>
                    {{-- รายละเอียดด้านขวา (70%) --}}
                    <div class="col-md-9">
                        <div class="card-body">
                            {{-- FIX: ใช้ Inline Style เป็นสีม่วงที่สว่างขึ้น (#9370DB - MediumPurple) เพื่อให้อ่านง่ายใน Dark Mode --}}
                            <h4 class="card-title" style="color: #9370DB;">{{ $product->name }}</h4>
                            <p class="card-text text-secondary mb-2">
                                Category: {{ $product->category->name ?? 'N/A' }}
                            </p>
                            {{-- ใช้ Str::limit เพื่อจำกัดจำนวนตัวอักษร --}}
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 150) }}</p>

                            <p class="card-text h5 text-danger">${{ number_format($product->price, 2) }}</p>

                            <div class="d-flex justify-content-start align-items-center mt-3">
                                <a href="{{ route('products.show', $product->product_id) }}" class="btn btn-primary me-2">View Details</a>

                                <form action="{{ route('cart.add', $product->product_id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    No products found matching your criteria.
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection