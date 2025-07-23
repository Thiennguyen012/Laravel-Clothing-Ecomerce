<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel E-commerce</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    @include('layouts.navigation')
    
    <!-- Hero Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                    Chào mừng đến với 
                    <span class="text-blue-600">Laravel E-commerce</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-600 max-w-2xl mx-auto">
                    Khám phá bộ sưu tập sản phẩm tuyệt vời với chất lượng cao và giá cả hợp lý. 
                    Trải nghiệm mua sắm trực tuyến tuyệt vời nhất tại đây.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            Vào Dashboard
                        </a>
                        <a href="{{ route('products') }}" 
                           class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600">
                            Xem sản phẩm <span aria-hidden="true">→</span>
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            Bắt đầu mua sắm
                        </a>
                        <a href="{{ route('login') }}" 
                           class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600">
                            Đăng nhập <span aria-hidden="true">→</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Tại sao chọn chúng tôi?
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Những lý do khiến khách hàng tin tướng và lựa chọn
                </p>
            </div>
            
            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Giao hàng nhanh</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Giao hàng nhanh chóng trong 24h tại nội thành
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Chất lượng đảm bảo</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Sản phẩm chính hãng, chất lượng được kiểm định
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Hỗ trợ 24/7</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Đội ngũ hỗ trợ khách hàng 24/7 nhiệt tình
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    @guest
    <div class="bg-blue-600">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                <span class="block">Sẵn sàng bắt đầu?</span>
                <span class="block text-blue-200">Tạo tài khoản miễn phí ngay hôm nay.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                        Đăng ký ngay
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 hover:bg-blue-400">
                        Đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endguest
</body>
</html>
