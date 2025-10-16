@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Order History</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if($orders->isEmpty())
        <div class="alert alert-info" role="alert">
            You have not placed any orders yet.
        </div>
    @else
        @foreach($orders as $order)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <strong>Order #{{ $order->order_id }}</strong>
                    <span class="text-muted ms-2">Placed on {{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <span class="badge 
                    @if($order->status == 'COMPLETED') bg-success 
                    @elseif($order->status == 'SHIPPED') bg-info 
                    @else bg-warning @endif">
                    {{ $order->status }}
                </span>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($order->items as $item)
                        <li class="list-group-item">{{ $item->product->name ?? 'Product not found' }} (x{{ $item->quantity }})</li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <strong>Total: ${{ number_format($order->total_amount, 2) }}</strong>
                
                <div>
                    {{-- ปุ่ม View Details จะถูกสร้างในขั้นตอนต่อไป --}}
                    {{-- <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-sm btn-outline-primary">View Details</a> --}}
                    
                    {{-- ปุ่ม Confirm Delivery จะแสดงเมื่อสถานะไม่ใช่ COMPLETED --}}
                    @if($order->status != 'COMPLETED')
                        <form action="{{ route('customer.order.confirm', $order->order_id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you have received all items in this order?');">
                                Confirm Delivery
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection

