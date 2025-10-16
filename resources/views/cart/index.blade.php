@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Shopping Cart</h1>

    @if(session('cart') && count(session('cart')) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th class="text-end">Subtotal</th>
                    <th>Action</th> {{-- เพิ่มคอลัมน์ใหม่สำหรับปุ่มลบ --}}
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                    <tr>
                        <td>
                            <img src="{{ $details['image_url'] ?? 'https://via.placeholder.com/50' }}" width="50" height="50" class="me-2">
                            {{ $details['name'] }}
                        </td>
                        <td>${{ number_format($details['price'], 2) }}</td>
                        
                        {{-- 1. เพิ่ม FORM สำหรับ UPDATE QUANTITY --}}
                        <td>
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" 
                                       min="1" style="width: 70px;" class="form-control form-control-sm"
                                       onchange="this.form.submit()"> {{-- ใช้ onchange เพื่อส่งฟอร์มทันทีที่แก้ไข --}}
                            </form>
                        </td>

                        <td class="text-end">${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                        
                        {{-- 2. นำ FORM REMOVE เข้ามาในเซลล์ Action --}}
                        <td> 
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Are you sure you want to remove this item?');">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                {{-- 3. ลบ @endforeach ตัวที่ซ้ำออก --}}
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"></td> {{-- เพิ่ม colspan เพื่อให้ Total ตรง --}}
                    <td class="text-end"><strong>Total</strong></td>
                    <td class="text-end"><strong>${{ number_format($total, 2) }}</strong></td>
                    <td></td> {{-- เว้นว่างไว้สำหรับคอลัมน์ Action --}}
                </tr>
            </tfoot>
        </table>
    @else
        <div class="alert alert-info">
            Your cart is empty!
        </div>
    @endif

    <a href="{{ url('/products') }}" class="btn btn-secondary">Continue Shopping</a>
    <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
</div>
@endsection