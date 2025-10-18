{{-- ใช้ Layout หลัก app.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    
    {{-- Header และต้อนรับ --}}
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h1><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</h1>
        {{-- สมมติว่าต้องการแสดงชื่อผู้ใช้ตรงนี้ --}}
        <p class="lead mb-0">Welcome back, **{{ Auth::user()->name }}**!</p> 
    </div>

    {{-- การ์ดสรุปข้อมูล (Summary Cards) --}}
    
    {{-- แถวที่ 1: 3 ใบ (4 + 4 + 4 = 12 คอลัมน์) --}}
    <div class="row mb-4 g-4"> 
        
        {{-- Total Products --}}
        <div class="col-lg-4 col-md-6">
            <div class="card text-white bg-primary shadow-sm h-100">
                <div class="card-body">
                    <i class="bi bi-box-seam fs-3 float-end opacity-50"></i>
                    <h5 class="card-title text-uppercase fw-light">Total Products</h5>
                    <p class="card-text fs-3 fw-bold">{{ number_format($totalProducts) }}</p>
                </div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="col-lg-4 col-md-6">
            <div class="card text-white bg-success shadow-sm h-100">
                <div class="card-body">
                    <i class="bi bi-clipboard-check fs-3 float-end opacity-50"></i>
                    <h5 class="card-title text-uppercase fw-light">Total Orders</h5>
                    <p class="card-text fs-3 fw-bold">{{ number_format($totalOrders) }}</p>
                </div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="col-lg-4 col-md-6">
            <div class="card text-white bg-warning shadow-sm h-100">
                <div class="card-body">
                    <i class="bi bi-clock-history fs-3 float-end opacity-50"></i>
                    <h5 class="card-title text-uppercase fw-light">Pending Orders</h5>
                    <p class="card-text fs-3 fw-bold">{{ number_format($pendingOrders) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- แถวที่ 2: 2 ใบ (6 + 6 = 12 คอลัมน์) --}}
    <div class="row mb-5 g-4"> 

        {{-- Total Revenue (รายได้รวม) --}}
        <div class="col-lg-6 col-md-6">
            <div class="card text-white bg-danger shadow-sm h-100">
                <div class="card-body">
                    <i class="bi bi-currency-dollar fs-3 float-end opacity-50"></i>
                    <h5 class="card-title text-uppercase fw-light">Total Revenue</h5>
                    <p class="card-text fs-3 fw-bold">${{ number_format($totalRevenue ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
        
        {{-- Total Items Sold (จำนวนชิ้นที่ขาย) --}}
        <div class="col-lg-6 col-md-6">
            <div class="card text-white bg-info shadow-sm h-100">
                <div class="card-body">
                    <i class="bi bi-cart-check fs-3 float-end opacity-50"></i>
                    <h5 class="card-title text-uppercase fw-light">Total Items Sold</h5>
                    <p class="card-text fs-3 fw-bold">{{ number_format($totalItemsSold ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>

    <hr>
    
    {{-- Quick Actions Section --}}
    <h2 class="h4 border-bottom pb-2 mb-4"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h2>
    <div class="mb-5">
        <a href="{{ route('admin.products.create') }}" class="btn btn-lg btn-success me-2">
            <i class="bi bi-box-seam-fill me-2"></i>Add New Product
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-lg btn-secondary">
            <i class="bi bi-clipboard-list me-2"></i>Manage Orders
        </a>
    </div>

    {{-- Recent Products Table --}}
    <h2 class="h4 border-bottom pb-2 mb-4"><i class="bi bi-box-seam me-2"></i>Recent Products</h2>
    
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 30%;">Name</th>
                            <th class="text-end" style="width: 15%;">Price</th>
                            <th class="text-center" style="width: 15%;">Stock</th>
                            <th class="text-center" style="width: 15%;">Total Sold</th>
                            <th class="text-center" style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- ใช้ $recentProducts ซึ่งถูกส่งมาจาก AdminController --}}
                        @forelse ($recentProducts as $product)
                        <tr>
                            <td class="text-muted">#{{ $product->product_id }}</td>
                            <td>{{ $product->name }}</td>
                            <td class="text-end fw-bold">${{ number_format($product->price, 2) }}</td>
                            <td class="text-center">
                                {{ $product->stock_quantity }}
                                @if ($product->stock_quantity < 10)
                                    <span class="badge bg-warning ms-1">Low</span>
                                @endif
                            </td>
                            <td class="text-center fw-bold text-success">
                                {{-- แสดงยอดขายรวมของสินค้าแต่ละชิ้น --}}
                                {{ number_format($product->total_sold ?? 0) }} 
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this product?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-info-circle fs-4 d-block mb-1"></i>
                                No recent products found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection