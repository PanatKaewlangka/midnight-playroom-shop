@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Checkout Summary</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="row">
        
        {{-- 1. ORDER SUMMARY --}}
        <div class="col-md-7">
            <h2 class="h4">Order Details</h2>
            <ul class="list-group mb-4">
                {{-- เปลี่ยนจาก $cart เป็น $cartItems --}}
                @foreach($cartItems as $id => $details)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        {{ $details['name'] }} 
                        <small class="text-muted"> (x{{ $details['quantity'] }})</small>
                    </div>
                    <span>${{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between align-items-center fw-bold fs-5">
                    Total Amount
                    <span>${{ number_format($total, 2) }}</span>
                </li>
            </ul>
        </div>

        {{-- 2. SHIPPING/BILLING FORM --}}
        <div class="col-md-5">
            <h2 class="h4">Shipping Information</h2>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('checkout.place_order') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                   value="{{ old('phone', $user->phone_number ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Shipping Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $user->address ?? '') }}</textarea>
                        </div>
                        
                        <hr>
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            Place Order - ${{ number_format($total, 2) }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4 text-center">
        <a href="{{ route('cart.index') }}" class="btn btn-link text-secondary">
             &larr; Back to Cart
        </a>
    </div>

</div>
@endsection

