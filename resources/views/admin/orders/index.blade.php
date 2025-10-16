@extends('layouts.app')

@section('content')
<div class="container">
    <h1><i class="bi bi-clipboard-list"></i> Order Management</h1>
    <p><a href="{{ route('admin.dashboard') }}">Back to Dashboard</a></p>

    {{-- แสดง Success/Error Message --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-hover">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {{-- $orders ถูกส่งมาจาก AdminController@ordersIndex --}}
        @forelse($orders as $order)
        <tr>
            <td>#{{ $order->order_id }}</td>
            <td>{{ $order->user->name ?? 'N/A' }}</td>
            <td>${{ number_format($order->total_amount, 2) }}</td>
            <td>
                <span class="badge 
                    @if($order->status == 'COMPLETED') bg-success 
                    @elseif($order->status == 'PENDING') bg-warning 
                    @else bg-secondary @endif">
                    {{ $order->status }}
                </span>
            </td>
            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order->order_id) }}" class="btn btn-sm btn-info text-white">View</a>
                
                {{-- ปุ่มสำหรับ Admin เพื่อเปลี่ยนสถานะเป็น COMPLETED --}}
                @if ($order->status !== 'COMPLETED')
                    <form action="{{ route('admin.order.complete', $order->order_id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success" 
                                onclick="return confirm('Mark Order #{{ $order->order_id }} as COMPLETED?');">
                            Complete
                        </button>
                    </form>
                @else
                    {{-- แสดงสถานะ Completed ในคอลัมน์ Actions เมื่อเสร็จสิ้นแล้ว --}}
                    <span class="badge bg-success">Completed</span>
                @endif
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="6">No orders found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination links --}}
<div class="d-flex justify-content-center">
    {{ $orders->links() }}
</div>
</div>
@endsection