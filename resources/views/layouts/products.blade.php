<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Sản phẩm' }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            {{ $pageTitle ?? 'Sản phẩm' }}
                        </h1>
                        @if(isset($pageDescription))
                            <p class="mt-1 text-sm text-gray-500">{{ $pageDescription }}</p>
                        @endif
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        @yield('header-actions')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                <!-- Sidebar Filters -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                            </svg>
                            Bộ lọc
                        </h3>

                        <!-- Categories Filter -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Danh mục</h4>
                            <div class="space-y-2">
                                <!-- All Products -->
                                <label class="flex items-center">
                                    <input type="radio" name="category" value="" 
                                           {{ !request('category') && !isset($currentCategory) ? 'checked' : '' }}
                                           onchange="filterProducts()"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-sm text-gray-700">Tất cả sản phẩm</span>
                                    @if(isset($totalProducts))
                                        <span class="ml-auto text-xs text-gray-500">({{ $totalProducts }})</span>
                                    @endif
                                </label>

                                <!-- Categories -->
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $category)
                                        <label class="flex items-center">
                                            <input type="radio" name="category" value="{{ $category->category_id }}" 
                                                   {{ (request('category') == $category->category_id) || (isset($currentCategory) && $currentCategory->category_id == $category->category_id) ? 'checked' : '' }}
                                                   onchange="filterProducts()"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="ml-3 text-sm text-gray-700">{{ $category->category_name }}</span>
                                            @if($category->products)
                                                <span class="ml-auto text-xs text-gray-500">({{ $category->products->count() }})</span>
                                            @endif
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Khoảng giá</h4>
                            <div class="space-y-2">
                                @php
                                    $currentMinPrice = request()->route('minPrice');
                                    $currentMaxPrice = request()->route('maxPrice');
                                    $currentPriceRange = '';
                                    
                                    if ($currentMinPrice !== null && $currentMaxPrice !== null) {
                                        if ($currentMinPrice == 0 && $currentMaxPrice == 500000) {
                                            $currentPriceRange = '0-500000';
                                        } elseif ($currentMinPrice == 500000 && $currentMaxPrice == 1000000) {
                                            $currentPriceRange = '500000-1000000';
                                        } elseif ($currentMinPrice == 1000000 && $currentMaxPrice == 2000000) {
                                            $currentPriceRange = '1000000-2000000';
                                        } elseif ($currentMinPrice == 2000000 && $currentMaxPrice == 999999999) {
                                            $currentPriceRange = '2000000+';
                                        }
                                    }
                                @endphp
                                
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="" 
                                           {{ !request('price_range') && !$currentMinPrice ? 'checked' : '' }}
                                           onchange="filterProducts()"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-sm text-gray-700">Tất cả</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="0-500000" 
                                           {{ (request('price_range') == '0-500000') || ($currentPriceRange == '0-500000') ? 'checked' : '' }}
                                           onchange="filterProducts()"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-sm text-gray-700">Dưới 500.000đ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="500000-1000000" 
                                           {{ (request('price_range') == '500000-1000000') || ($currentPriceRange == '500000-1000000') ? 'checked' : '' }}
                                           onchange="filterProducts()"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-sm text-gray-700">500.000đ - 1.000.000đ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="1000000-2000000" 
                                           {{ (request('price_range') == '1000000-2000000') || ($currentPriceRange == '1000000-2000000') ? 'checked' : '' }}
                                           onchange="filterProducts()"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-sm text-gray-700">1.000.000đ - 2.000.000đ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="2000000+" 
                                           {{ (request('price_range') == '2000000+') || ($currentPriceRange == '2000000+') ? 'checked' : '' }}
                                           onchange="filterProducts()"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-sm text-gray-700">Trên 2.000.000đ</span>
                                </label>
                            </div>
                        </div>

                        <!-- Stock Status Filter -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Tình trạng</h4>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="in_stock" value="1" 
                                           {{ request('in_stock') ? 'checked' : '' }}
                                           onchange="filterProducts()"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-700">Còn hàng</span>
                                </label>
                            </div>
                        </div>

                        <!-- Clear Filters -->
                        <div class="pt-4 border-t border-gray-200">
                            <button onclick="clearFilters()" 
                                    class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Xóa bộ lọc
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="lg:col-span-3 mt-8 lg:mt-0">
                    <!-- Sort & View Options -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <!-- Results Count -->
                            <div class="mb-4 sm:mb-0">
                                @if(isset($products) && $products->count() > 0)
                                    <p class="text-sm text-gray-700">
                                        Hiển thị <span class="font-medium">{{ $products->count() }}</span> sản phẩm
                                        @if(isset($totalProducts) && $totalProducts != $products->count())
                                            trong tổng số <span class="font-medium">{{ $totalProducts }}</span> sản phẩm
                                        @endif
                                    </p>
                                @endif
                            </div>

                            <!-- Sort Options -->
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-700">Sắp xếp:</label>
                                <select name="sort" onchange="filterProducts()" 
                                        class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Current Filters Display -->
                    @if(request()->hasAny(['category', 'price_range', 'in_stock', 'sort']) || isset($currentCategory) || request()->route('minPrice'))
                        <div class="mb-6">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm font-medium text-gray-700">Đang lọc:</span>
                                
                                @if(isset($currentCategory))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $currentCategory->category_name }}
                                        <button onclick="removeFilter('category')" class="ml-2 hover:text-blue-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </span>
                                @elseif(request('category') && isset($categories))
                                    @php
                                        $currentCategoryFromQuery = $categories->where('category_id', request('category'))->first();
                                    @endphp
                                    @if($currentCategoryFromQuery)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ $currentCategoryFromQuery->category_name }}
                                            <button onclick="removeFilter('category')" class="ml-2 hover:text-blue-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </span>
                                    @endif
                                @endif

                                @if(request('price_range'))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Giá: {{ request('price_range') }}
                                        <button onclick="removeFilter('price_range')" class="ml-2 hover:text-green-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </span>
                                @elseif(request()->route('minPrice') && request()->route('maxPrice'))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Giá: {{ number_format(request()->route('minPrice')) }}đ - {{ number_format(request()->route('maxPrice')) }}đ
                                        <button onclick="removeFilter('price_range')" class="ml-2 hover:text-green-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </span>
                                @endif

                                @if(request('in_stock'))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        Còn hàng
                                        <button onclick="removeFilter('in_stock')" class="ml-2 hover:text-yellow-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif                    <!-- Products Content -->
                    @yield('products-content')
                </div>
            </div>
        </div>
    </div>

    <!-- Filter JavaScript -->
    <script>
        function filterProducts() {
            // Get category
            const category = document.querySelector('input[name="category"]:checked');
            
            // Get price range
            const priceRange = document.querySelector('input[name="price_range"]:checked');
            
            // Xử lý chuyển đổi category trước
            if (category && category.value) {
                // Nếu có cả category và price range
                if (priceRange && priceRange.value) {
                    let minPrice, maxPrice;
                    
                    // Parse price range
                    switch(priceRange.value) {
                        case '0-500000':
                            minPrice = 0;
                            maxPrice = 500000;
                            break;
                        case '500000-1000000':
                            minPrice = 500000;
                            maxPrice = 1000000;
                            break;
                        case '1000000-2000000':
                            minPrice = 1000000;
                            maxPrice = 2000000;
                            break;
                        case '2000000+':
                            minPrice = 2000000;
                            maxPrice = 999999999;
                            break;
                        default:
                            // Nếu chọn "Tất cả" price, chỉ chuyển đến category
                            window.location.href = '/products/' + category.value;
                            return;
                    }
                    
                    // Category + Price: /products/{id}/{minPrice}-{maxPrice}
                    window.location.href = '/products/' + category.value + '/' + minPrice + '-' + maxPrice;
                    return;
                } else {
                    // Chỉ có category, không có price range
                    window.location.href = '/products/' + category.value;
                    return;
                }
            }
            
            // Nếu chọn "Tất cả sản phẩm" (category value = "")
            if (category && !category.value) {
                // Kiểm tra xem có price range không
                if (priceRange && priceRange.value) {
                    let minPrice, maxPrice;
                    
                    // Parse price range
                    switch(priceRange.value) {
                        case '0-500000':
                            minPrice = 0;
                            maxPrice = 500000;
                            break;
                        case '500000-1000000':
                            minPrice = 500000;
                            maxPrice = 1000000;
                            break;
                        case '1000000-2000000':
                            minPrice = 1000000;
                            maxPrice = 2000000;
                            break;
                        case '2000000+':
                            minPrice = 2000000;
                            maxPrice = 999999999;
                            break;
                        default:
                            // Nếu chọn "Tất cả" price, về trang chính
                            window.location.href = '/products';
                            return;
                    }
                    
                    // Price only: /products/{minPrice}-{maxPrice}
                    window.location.href = '/products/' + minPrice + '-' + maxPrice;
                    return;
                } else {
                    // Không có category và không có price, về trang all products
                    window.location.href = '/products';
                    return;
                }
            }
            
            // Xử lý khi chỉ thay đổi price range mà không thay đổi category
            if (priceRange && priceRange.value) {
                let minPrice, maxPrice;
                
                // Parse price range
                switch(priceRange.value) {
                    case '0-500000':
                        minPrice = 0;
                        maxPrice = 500000;
                        break;
                    case '500000-1000000':
                        minPrice = 500000;
                        maxPrice = 1000000;
                        break;
                    case '1000000-2000000':
                        minPrice = 1000000;
                        maxPrice = 2000000;
                        break;
                    case '2000000+':
                        minPrice = 2000000;
                        maxPrice = 999999999;
                        break;
                    default:
                        // Nếu chọn "Tất cả" price, kiểm tra current category
                        const currentCategoryId = getCurrentCategoryId();
                        if (currentCategoryId) {
                            window.location.href = '/products/' + currentCategoryId;
                        } else {
                            window.location.href = '/products';
                        }
                        return;
                }
                
                // Kiểm tra xem đang ở trang category nào
                const currentCategoryId = getCurrentCategoryId();
                if (currentCategoryId) {
                    // Category + Price: /products/{id}/{minPrice}-{maxPrice}
                    window.location.href = '/products/' + currentCategoryId + '/' + minPrice + '-' + maxPrice;
                } else {
                    // Price only: /products/{minPrice}-{maxPrice}
                    window.location.href = '/products/' + minPrice + '-' + maxPrice;
                }
                return;
            }
            
            // For other filters (stock, sort), use query parameters on current page
            const form = new FormData();
            
            // Get stock status
            const inStock = document.querySelector('input[name="in_stock"]:checked');
            if (inStock) {
                form.append('in_stock', '1');
            }
            
            // Get sort
            const sort = document.querySelector('select[name="sort"]');
            if (sort && sort.value) {
                form.append('sort', sort.value);
            }
            
            // Build URL with query parameters
            const params = new URLSearchParams(form);
            const baseUrl = window.location.pathname;
            const url = baseUrl + (params.toString() ? '?' + params.toString() : '');
            window.location.href = url;
        }
        
        function clearFilters() {
            window.location.href = '/products';
        }
        
        function removeFilter(filterName) {
            if (filterName === 'category') {
                // If removing category filter, go to all products
                window.location.href = '/products';
                return;
            }
            
            if (filterName === 'price_range') {
                // If removing price filter, check if we're on a category page
                const path = window.location.pathname;
                const categoryMatch = path.match(/\/products\/(\d+)\/\d+-\d+/);
                if (categoryMatch) {
                    // We're on category page with price filter, go to category only
                    window.location.href = '/products/' + categoryMatch[1];
                } else {
                    // We're on price-only page, go to all products
                    window.location.href = '/products';
                }
                return;
            }
            
            const url = new URL(window.location);
            url.searchParams.delete(filterName);
            window.location.href = url.toString();
        }
        
        function getCurrentCategoryId() {
            // Get category ID from current URL
            const path = window.location.pathname;
            const matches = path.match(/\/products\/(\d+)/);
            return matches ? matches[1] : null;
        }
    </script>
</body>
</html>
