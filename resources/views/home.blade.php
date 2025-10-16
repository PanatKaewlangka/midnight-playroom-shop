{{-- 1. บอกว่าให้ใช้ Layout หลักที่เราทำไว้ --}}
@extends('layouts.app')

{{-- 2. กำหนดว่าเนื้อหาข้างล่างนี้ จะถูกนำไปใส่ในส่วน @yield('content') --}}
@section('content')

{{-- ** CSS Custom Style สำหรับธีมนี้ ** --}}
<style>
    /* ตั้งค่าสีข้อความใน Welcome Block ให้เป็นสีแดง/เทา */
    .welcome-block .display-5 {
        color: var(--bs-danger) !important; /* เน้นด้วยสีแดง */
    }
    .welcome-block .lead {
        color: var(--bs-secondary) !important; /* ข้อความรองเป็นสีเทา */
    }
    /* ตั้งค่ารูปภาพที่ใช้แทนไอคอน */
    .welcome-block .icon-image {
        width: 80px; /* กำหนดขนาดความกว้างที่เหมาะสม */
        height: auto;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- ** ส่วน Dashboard หลัก (The Member Mausoleum) ** --}}

            {{-- แบนเนอร์ด้านบน --}}
            <div class="mb-4 text-center">
                {{-- FIX: กรุณาเปลี่ยน URL รูปภาพนี้เป็น Banner ของคุณเอง --}}
                <img src="/images/home/image.png" alt="The Midnight Playroom Banner" class="img-fluid rounded shadow">
            </div>

            {{-- บล็อกต้อนรับหลัก (Welcome Block) --}}
            <div class="p-5 rounded-lg text-center shadow-lg mb-5 welcome-block"
                 style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color);">

                {{-- ** ส่วนที่เปลี่ยน: ใช้แท็ก img แทนไอคอน ** --}}
                <div class="mb-3">
                    {{-- 🛑 FIX: ใส่ URL รูปภาพโลงศพของคุณที่นี่ (เช่น /images/coffin.svg หรือ /images/coffin.png) --}}
                    <img src="/images/home/tombstone.png" alt="Coffin Icon" class="icon-image mb-2 w-25"> 
                </div>

                {{-- ต้อนรับผู้ใช้ (ปลอดภัยสำหรับ Guest และ Member) --}}
                @auth
                    {{-- สำหรับ Member ที่ล็อกอินแล้ว --}}
                    <h1 class="display-5">Welcome to the Member Mausoleum!</h1>
                    <p class="lead">Hey there, {{ Auth::user()->name }}! Your haunting hours have begun. Manage your collection and track your ghostly purchases below.</p>
                @else
                    {{-- สำหรับ Guest (หน้าแนะนำเว็บไซต์) --}}
                    <h1 class="display-5">Welcome to The Midnight Playroom!</h1>
                    <p class="lead">A realm where nightmares wear velvet and the dolls never stop watching. Log in or register to join our cursed collection!</p>
                @endauth
            </div>
            
            <div class="p-4 rounded-lg bg-body-tertiary shadow-sm">
                @auth
                    <h4 class="mb-4 border-bottom border-danger pb-2">Your Quick Haunts</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('orders.index') }}" class="btn btn-danger btn-lg w-100 py-3">
                                <i class="bi bi-box-seam me-2"></i> Track My Cursed Orders
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('products.index') }}" class="btn btn-dark btn-lg w-100 py-3">
                                <i class="bi bi-search me-2"></i> Find More Playmates
                            </a>
                        </div>
                    </div>
                @else
                    <h4 class="mb-4 border-bottom border-danger pb-2">Join the Cursed</h4>
                    <div class="d-grid gap-3">
                        <a href="{{ route('login') }}" class="btn btn-danger btn-lg py-3">
                            <i class="bi bi-door-open me-2"></i> Enter the Mausoleum (Login)
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-dark btn-lg py-3">
                            <i class="bi bi-person-plus me-2"></i> Create a Haunt (Register)
                        </a>
                    </div>
                @endauth
            </div>

            <div class="mt-5 pt-3 border-top border-danger">
                <p class="text-center text-muted">Manage your haunting collection responsibly.</p>
            </div>
        </div>
    </div>
</div>
@endsection