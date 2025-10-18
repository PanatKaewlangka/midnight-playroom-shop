{{-- ใช้ Layout หลัก app.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pencil-square me-2"></i>Edit Product: {{ $product->name }}
                </div>

                <div class="card-body">
                    {{-- แสดง Validation Errors ถ้ามี --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form ยังคงเป็น multipart/form-data อยู่ แต่ถ้าไม่ใช้ file upload ก็สามารถลบออกได้ --}}
                    <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- ใช้ Method PUT สำหรับการ Update --}}

                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ส่วนที่แก้ไข: ยืนยันให้เป็น type="text" สำหรับการพิมพ์ URL --}}
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Product Image **URL**</label>
                            @if($product->image_url)
                                <div class="mb-2">
                                    {{-- ตรวจสอบว่ารูปภาพเป็น URL ภายนอก หรือเป็น path ใน storage ก่อนแสดง --}}
                                    @php
                                        $imageUrl = Str::startsWith($product->image_url, ['http://', 'https://']) ? $product->image_url : asset('storage/' . $product->image_url);
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" style="max-height: 100px; border-radius: 5px;">
                                    <small class="d-block text-muted">Current Image (URL/Path: **{{ $product->image_url }}**)</small>
                                </div>
                            @endif
                            {{-- *** ให้ค่าเก่าเป็นค่าปัจจุบันของสินค้า และเป็น type="text" สำหรับพิมพ์ URL *** --}}
                            <input type="text" class="form-control" id="image_url" name="image_url" value="{{ old('image_url', $product->image_url) }}">
                            <small class="text-muted">Enter the full URL (e.g., https://example.com/image.jpg) or the storage path.</small>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection