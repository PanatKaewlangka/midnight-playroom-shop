{{-- ใช้ Layout หลัก app.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">
<i class="bi bi-plus-circle-fill me-2"></i>Create New Product
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

                {{-- **แก้ไข:** ลบ enctype="multipart/form-data" ออกเพราะเป็นการส่ง URL ไม่ใช่ไฟล์ --}}
                <form action="{{ route('admin.products.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option selected disabled value="">Choose...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- **แก้ไข:** เปลี่ยนจาก Input type="file" เป็น type="text" สำหรับใส่ URL --}}
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Product Image URL/Path (Optional)</label>
                        <input type="text" class="form-control" id="image_url" name="image_url" value="{{ old('image_url') }}">
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
@endsection