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
                                           id="inStockCheckbox"
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
        // Khởi tạo trạng thái checkbox khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            const inStockCheckbox = document.getElementById('inStockCheckbox');
            const currentUrl = window.location.pathname;
            
            // Kiểm tra nếu URL có chứa "/inStock" thì check checkbox
            if (currentUrl.includes('/inStock')) {
                inStockCheckbox.checked = true;
            } else {
                inStockCheckbox.checked = false;
            }
        });

        function filterProducts() {
            // Lấy giá trị của các filters
            const category = document.querySelector('input[name="category"]:checked');
            const priceRange = document.querySelector('input[name="price_range"]:checked');
            const inStock = document.querySelector('input[name="in_stock"]:checked');
            
            let baseUrl = '';
            
            // Kiểm tra nếu có category được chọn (và không phải "Tất cả sản phẩm")
            if (category && category.value) {
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
                            // Nếu chọn "Tất cả" price, chỉ chuyển đến category
                            if (inStock) {
                                baseUrl = '/products/' + category.value + '/inStock';
                            } else {
                                baseUrl = '/products/' + category.value;
                            }
                            window.location.href = baseUrl;
                            return;
                    }
                    
                    // Category + Price
                    if (inStock) {
                        baseUrl = '/products/' + minPrice + '-' + maxPrice + '/' + category.value + '/inStock';
                    } else {
                        baseUrl = '/products/' + minPrice + '-' + maxPrice + '/' + category.value;
                    }
                } else {
                    // Chỉ có category, không có price range
                    if (inStock) {
                        baseUrl = '/products/' + category.value + '/inStock';
                    } else {
                        baseUrl = '/products/' + category.value;
                    }
                }
                
                window.location.href = baseUrl;
                return;
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
                            if (inStock) {
                                baseUrl = '/products/inStock';
                            } else {
                                baseUrl = '/products';
                            }
                            window.location.href = baseUrl;
                            return;
                    }
                    
                    // Price only
                    if (inStock) {
                        baseUrl = '/products/' + minPrice + '-' + maxPrice + '/inStock';
                    } else {
                        baseUrl = '/products/' + minPrice + '-' + maxPrice;
                    }
                } else {
                    // Không có category và không có price
                    if (inStock) {
                        baseUrl = '/products/inStock';
                    } else {
                        baseUrl = '/products';
                    }
                }
                
                window.location.href = baseUrl;
                return;
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
                            if (inStock) {
                                baseUrl = '/products/' + currentCategoryId + '/inStock';
                            } else {
                                baseUrl = '/products/' + currentCategoryId;
                            }
                        } else {
                            if (inStock) {
                                baseUrl = '/products/inStock';
                            } else {
                                baseUrl = '/products';
                            }
                        }
                        window.location.href = baseUrl;
                        return;
                }
                
                // Kiểm tra xem đang ở trang category nào
                const currentCategoryId = getCurrentCategoryId();
                if (currentCategoryId) {
                    // Category + Price
                    if (inStock) {
                        baseUrl = '/products/' + minPrice + '-' + maxPrice + '/' + currentCategoryId + '/inStock';
                    } else {
                        baseUrl = '/products/' + minPrice + '-' + maxPrice + '/' + currentCategoryId;
                    }
                } else {
                    // Price only
                    if (inStock) {
                        baseUrl = '/products/' + minPrice + '-' + maxPrice + '/inStock';
                    } else {
                        baseUrl = '/products/' + minPrice + '-' + maxPrice;
                    }
                }
                
                window.location.href = baseUrl;
                return;
            }
            
            // Chỉ có inStock filter hoặc không có filter nào
            if (inStock) {
                // Kiểm tra current URL để build proper inStock URL
                const currentCategoryId = getCurrentCategoryId();
                const currentPriceRange = getCurrentPriceRange();
                
                if (currentCategoryId && currentPriceRange) {
                    // Category + Price + InStock
                    baseUrl = '/products/' + currentPriceRange.minPrice + '-' + currentPriceRange.maxPrice + '/' + currentCategoryId + '/inStock';
                } else if (currentCategoryId) {
                    // Category + InStock
                    baseUrl = '/products/' + currentCategoryId + '/inStock';
                } else if (currentPriceRange) {
                    // Price + InStock
                    baseUrl = '/products/' + currentPriceRange.minPrice + '-' + currentPriceRange.maxPrice + '/inStock';
                } else {
                    // Just InStock
                    baseUrl = '/products/inStock';
                }
            } else {
                // No inStock, fallback to current page or products
                baseUrl = '/products';
            }
            
            window.location.href = baseUrl;
        }
        
        function clearFilters() {
            window.location.href = '/products';
        }
        
        function removeFilter(filterName) {
            if (filterName === 'category') {
                // If removing category filter, check if we have price range or inStock
                const path = window.location.pathname;
                const priceRangeMatch = path.match(/\/products\/(\d+)-(\d+)/);
                const isInStock = path.includes('/inStock');
                
                if (priceRangeMatch) {
                    // We have price range, keep it
                    if (isInStock) {
                        window.location.href = '/products/' + priceRangeMatch[1] + '-' + priceRangeMatch[2] + '/inStock';
                    } else {
                        window.location.href = '/products/' + priceRangeMatch[1] + '-' + priceRangeMatch[2];
                    }
                } else {
                    // No price range, check inStock only
                    if (isInStock) {
                        window.location.href = '/products/inStock';
                    } else {
                        window.location.href = '/products';
                    }
                }
                return;
            }
            
            if (filterName === 'price_range') {
                // If removing price filter, check if we're on a category page or inStock
                const path = window.location.pathname;
                const isInStock = path.includes('/inStock');
                
                // Check for category in price range URL: /products/{price}/{category}
                const categoryWithPriceMatch = path.match(/\/products\/\d+-\d+\/(\d+)/);
                
                if (categoryWithPriceMatch) {
                    // We're on category page with price filter, go to category only
                    if (isInStock) {
                        window.location.href = '/products/' + categoryWithPriceMatch[1] + '/inStock';
                    } else {
                        window.location.href = '/products/' + categoryWithPriceMatch[1];
                    }
                } else {
                    // We're on price-only page, go to all products
                    if (isInStock) {
                        window.location.href = '/products/inStock';
                    } else {
                        window.location.href = '/products';
                    }
                }
                return;
            }
            
            if (filterName === 'in_stock') {
                // Remove /inStock from current URL
                const currentUrl = window.location.pathname;
                const newUrl = currentUrl.replace('/inStock', '');
                window.location.href = newUrl || '/products';
                return;
            }
            
            // For query parameters
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
        
        function getCurrentPriceRange() {
            // Get price range from current URL
            const path = window.location.pathname;
            const matches = path.match(/\/products\/(\d+)-(\d+)/);
            if (matches) {
                return {
                    minPrice: matches[1],
                    maxPrice: matches[2]
                };
            }
            return null;
        }
    </script>
</body>
</html>
