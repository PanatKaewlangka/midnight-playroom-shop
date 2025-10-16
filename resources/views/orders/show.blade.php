{{-- ใช้ Layout หลัก app.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1>Order #{{ $order->order_id }} Details</h1>
            <p class="text-muted">Placed on {{ $order->created_at->format('M d, Y, H:i A') }}</p>
        </div>
    </div>

    {{-- แสดงข้อความ Success/Error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- *** ปุ่มสำหรับลูกค้ากดยืนยันรับสินค้า *** --}}
    @if ($order->user_id === Auth::id() && $order->status !== 'COMPLETED')
        <div class="alert alert-info d-flex justify-content-between align-items-center" role="alert">
            <span>
                Your order status is <strong>{{ $order->status }}</strong>. Please confirm receipt once your items arrive.
            </span>
            <form action="{{ route('customer.order.confirm', $order->order_id) }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('Do you confirm that you have received all items in this order?');">
                    <i class="bi bi-check-circle me-2"></i>I Have Received My Order
                </button>
            </form>
        </div>
    @endif
    {{-- *** สิ้นสุดปุ่มยืนยัน *** --}}

    <div class="card">
        <div class="card-header">
            <h4>Order Summary</h4>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Shipping Information --}}
                <div class="col-md-6">
                    <h5>Shipping Address</h5>
                    @php 
                        // แปลงข้อมูลที่อยู่ (ที่ถูกเก็บเป็น JSON) กลับมาเป็น Array เพื่อใช้งาน
                        $shipping = json_decode($order->shipping_address_snapshot, true); 
                    @endphp
                    <p>
                        <strong>{{ $shipping['name'] ?? 'N/A' }}</strong><br>
                        {{ $shipping['address'] ?? 'N/A' }}<br>
                        Phone: {{ $shipping['phone'] ?? 'N/A' }} <br>
                        Email: {{ $shipping['email'] ?? 'N/A' }} 
                    </p>
                </div>
                 {{-- Payment Information --}}
                <div class="col-md-6">
                    <h5>Payment Summary</h5>
                    <p><strong>Status:</strong> 
                        <span class="badge 
                            @if($order->status == 'COMPLETED') bg-success 
                            @elseif($order->status == 'SHIPPED') bg-info 
                            @else bg-warning @endif">
                            {{ $order->status }}
                        </span>
                    </p>
                    <p><strong>Total Paid:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>

            <hr>

            {{-- Order Items Table --}}
            <h5 class="mt-4">Items in this Order</h5>
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Price at Purchase</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Product Not Found' }}</td>
                        <td class="text-center">${{ number_format($item->price_at_purchase, 2) }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">${{ number_format($item->price_at_purchase * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end border-0"><strong>Grand Total</strong></td>
                        <td class="text-end border-0"><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Order History
            </a>
        </div>
    </div>
</div>
@endsection

