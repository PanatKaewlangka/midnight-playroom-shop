{{-- resources/views/admin/orders/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order #{{ $order->order_id }} (Admin View)</h1>
    <p><a href="{{ route('admin.orders.index') }}">Back to All Orders</a></p>

    <div class="row">
        
        {{-- Order Status and Completion Button --}}
        <div class="col-md-12 mb-4">
            <div class="card p-3 @if($order->status == 'COMPLETED') bg-success text-white @else bg-warning @endif">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Status: {{ $order->status }}</h4>
                    
                    {{-- ปุ่มสำหรับ Admin เพื่อเปลี่ยนสถานะเป็น COMPLETED --}}
                    @if ($order->status !== 'COMPLETED')
                        <form action="{{ route('admin.order.complete', $order->order_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-dark" 
                                    onclick="return confirm('Mark Order #{{ $order->order_id }} as COMPLETED?');">
                                Change to COMPLETED
                            </button>
                        </form>
                    @endif
                </div>
                <small class="mt-2">Customer: {{ $order->user->name }} (ID: {{ $order->user_id }})</small>
            </div>
        </div>

        {{-- Shipping Information --}}
        <div class="col-md-6 mb-4">
            <h4 class="mb-3">Shipping Address (Snapshot)</h4>
            <div class="card p-3">
                @php 
                    // แปลง JSON Snapshot เป็น Array
                    $shipping = json_decode($order->shipping_address_snapshot, true); 
                @endphp
                <p><strong>Name:</strong> {{ $shipping['name'] ?? 'N/A' }}</p>
                
                {{-- *** แก้ไขตรงนี้: ใช้ ?? เพื่อป้องกัน Undefined Array Key *** --}}
                <p><strong>Email:</strong> {{ $shipping['email'] ?? 'Not Recorded' }}</p>
                <p><strong>Phone:</strong> {{ $shipping['phone'] ?? 'Not Recorded' }}</p>
                <p><strong>Address:</strong> {{ $shipping['address'] ?? 'N/A' }}</p>
            </div>
        </div>
        
        {{-- Summary --}}
        <div class="col-md-6 mb-4">
            <h4 class="mb-3">Summary</h4>
            <div class="card p-3">
                <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>Total Items:</strong> {{ $order->items->sum('quantity') }}</p>
                <h3><strong>Grand Total:</strong> ${{ number_format($order->total_amount, 2) }}</h3>
            </div>
        </div>

        {{-- Order Items Table --}}
        <div class="col-md-12">
            <h4 class="mb-3">Items in Order</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Qty</th>
                        <th>Price at Purchase</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Product Deleted' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price_at_purchase, 2) }}</td>
                        <td>${{ number_format($item->price_at_purchase * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection