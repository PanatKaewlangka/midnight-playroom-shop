{{-- ใช้ Layout หลัก app.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p class="lead">Welcome back, {{ Auth::user()->name }}!</p>

    {{-- การ์ดสรุปข้อมูล --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text fs-3">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text fs-3">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending Orders</h5>
                    <p class="card-text fs-3">{{ $pendingOrders }}</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- ปุ่ม Actions --}}
    <h2>Quick Actions</h2>
    <div class="mb-4">
        {{-- แก้ไขชื่อ Route ตรงนี้ --}}
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary me-2"><i class="bi bi-plus-circle"></i> Add New Product</a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-info me-2"><i class="bi bi-clipboard-list"></i> View All Orders</a>
    </div>

    {{-- ตารางแสดงข้อมูลสินค้าล่าสุด --}}
    <h2 class="mt-5">Products in Store</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- เราจะย้าย Logic การดึงข้อมูลไปไว้ใน Controller แทน --}}
            @forelse ($recentProducts as $product)
            <tr>
                <td>#{{ $product->product_id }}</td>
                <td>{{ $product->name }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock_quantity }}</td>
                <td>
                    {{-- แก้ไขชื่อ Route ตรงนี้ --}}
                    <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn btn-sm btn-primary">Edit</a>
                    {{-- แก้ไขชื่อ Route ตรงนี้ --}}
                    <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No products found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

