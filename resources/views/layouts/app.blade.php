<!doctype html>
{{-- ใช้ data-bs-theme="light" เป็นค่าเริ่มต้น --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Midnight Playroom') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="fw-bold fs-5">The Midnight Playroom</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    {{-- Left Side Of Navbar --}}
                    <ul class="navbar-nav me-auto">
                        
                        {{-- Dashboard Link --}}
                        <li class="nav-item">
                            @php $isHomeActive = Route::is('home'); @endphp
                            {{-- เพิ่ม border-3 ที่นี่ --}}
                            <a class="nav-link fw-bold {{ $isHomeActive ? 'active border-bottom border-3 rounded-0' : '' }}" href="{{ url('/home') }}">
                                <i class="bi bi-house-door-fill me-1"></i> Dashboard
                            </a>
                        </li>
                        
                        {{-- Products Link --}}
                        <li class="nav-item">
                            @php $isProductsActive = Route::is('products.index') || Route::is('products.show'); @endphp
                            {{-- เพิ่ม border-3 ที่นี่ --}}
                            <a class="nav-link {{ $isProductsActive ? 'active fw-bold border-bottom border-3 rounded-0' : '' }}" href="{{ route('products.index') }}">
                                <i class="bi bi-box-seam me-1"></i> Products
                            </a>
                        </li>
                        
                        {{-- Cart Link (ส่วนที่นำกลับมา) --}}
                        <li class="nav-item">
                            @php $isCartActive = Route::is('cart.*'); @endphp
                            {{-- เพิ่ม border-3 ที่นี่ --}}
                            <a class="nav-link {{ $isCartActive ? 'active fw-bold border-bottom border-3 rounded-0' : '' }}" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart me-1"></i> Cart
                                
                                @php
                                    // Logic Cart Count ที่หายไป ถูกนำกลับมา
                                    $cartItems = session()->get('cart', []);
                                    $totalQuantity = 0;
                                    if (is_array($cartItems)) {
                                        foreach ($cartItems as $item) {
                                            $totalQuantity += $item['quantity'] ?? 0;
                                        }
                                    }
                                    $cartCount = $totalQuantity;
                                @endphp
                                
                                @if ($cartCount > 0) 
                                    <span class="badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                        <span class="visually-hidden">items in cart</span>
                                    </span>
                                @endif
                            </a> 
                        </li>
                    </ul>

                    {{-- Right Side Of Navbar --}}
                    <ul class="navbar-nav ms-auto">
                        
                        {{-- Theme Switcher Dropdown --}}
                        <li class="nav-item dropdown">
                            <button class="btn nav-link dropdown-toggle" id="bd-theme" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-circle-half"></i> <span class="d-none d-lg-inline">Theme</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light"><i class="bi bi-sun-fill me-2"></i>Light</button></li>
                                <li><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"><i class="bi bi-moon-stars-fill me-2"></i>Dark</button></li>
                                <li><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto"><i class="bi bi-circle-half me-2"></i>Auto</button></li>
                            </ul>
                        </li>

                        {{-- Authentication Links --}}
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    
                                    {{-- Admin Dashboard Link (ใน Dropdown) --}}
                                    @can('is_admin')
                                        <a class="dropdown-item fw-bold {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-person-badge me-2"></i> Admin Dashboard
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @endcan
                                    
                                    <a class="dropdown-item {{ Route::is('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                        <i class="bi bi-journal-text me-2"></i> Order History
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); confirmLogout();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Main Content Area --}}
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    {{-- Theme Switcher JavaScript --}}
    <script>
        (() => {
            'use strict'
            const getStoredTheme = () => localStorage.getItem('theme')
            const setStoredTheme = theme => localStorage.setItem('theme', theme)
            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme()
                if (storedTheme) {
                    return storedTheme
                }
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
            }
            const setTheme = theme => {
                if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.setAttribute('data-bs-theme', 'dark')
                } else {
                    document.documentElement.setAttribute('data-bs-theme', theme)
                }
            }
            setTheme(getPreferredTheme())
            window.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[data-bs-theme-value]')
                    .forEach(toggle => {
                        toggle.addEventListener('click', () => {
                            const theme = toggle.getAttribute('data-bs-theme-value')
                            setStoredTheme(theme)
                            setTheme(theme)
                        })
                    })
            })
        })()
    </script>
        {{-- *** บรรทัดที่ต้องเพิ่ม: ฟังก์ชัน Logout Alert *** --}}
        @section('scripts')
        <script>
            function confirmLogout() {
                let message = "Are you sure you want to log out? WARNING: Any items currently in your cart will be lost.";
                
                if (confirm(message)) {
                    document.getElementById('logout-form').submit();
                }
            }
        </script>
        @endsection
        {{-- ******************************************* --}}
        @yield('scripts') 
</body>
</html>