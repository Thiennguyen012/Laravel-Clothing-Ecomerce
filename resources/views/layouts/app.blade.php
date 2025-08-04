<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Sticky Cart Button -->
            <div class="fixed right-6 bottom-6 z-50">
                <a href="{{ route('cart') }}" class="group relative bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 ease-in-out transform hover:scale-110 block">
                    <!-- Cart Icon -->
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6M7 13h10M9 19a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z"/>
                    </svg>
                    
                    <!-- Cart Count Badge - Luôn có trong DOM, ẩn/hiện bằng JavaScript -->
                    <span id="cart-count-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center shadow-md border-2 border-white" style="display: none;">
                        0
                    </span>
                    
                    <!-- Simple Tooltip -->
                    <span class="absolute right-full mr-3 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white text-sm px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap pointer-events-none">
                        <span id="cart-tooltip">Giỏ hàng (trống)</span>
                    </span>
                </a>
            </div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @else
                @hasSection('header')
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            @yield('header')
                        </div>
                    </header>
                @endif
            @endisset

            <!-- Page Content -->
            <main>
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>

            @include('layouts.footer')
        </div>
        <script>
        // Function to update cart count in sticky button
        function updateCartCount(count) {
            const cartBadge = document.getElementById('cart-count-badge');
            const cartTooltip = document.getElementById('cart-tooltip');
            if (cartBadge) {
                cartBadge.textContent = count > 99 ? '99+' : count;
                cartBadge.classList.add('cart-count-bounce');
                if (count > 0) {
                    cartBadge.style.display = 'flex';
                } else {
                    cartBadge.style.display = 'none';
                }
                setTimeout(() => {
                    cartBadge.classList.remove('cart-count-bounce');
                }, 500);
            }
            if (cartTooltip) {
                if (count > 0) {
                    cartTooltip.textContent = `Giỏ hàng (${count} sản phẩm)`;
                } else {
                    cartTooltip.textContent = 'Giỏ hàng (trống)';
                }
            }
        }

        // Load cart count when page loads
        function loadCartCount() {
            fetch('/cart/count', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.count);
                } else {
                    updateCartCount(0);
                }
            })
            .catch(error => {
                updateCartCount(0);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadCartCount();
        });
        </script>
    </body>
</html>
