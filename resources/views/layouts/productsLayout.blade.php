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
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Header -->
        @hasSection('header')
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @else
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $pageTitle ?? 'Sản phẩm' }}
                    </h2>
                    @if(isset($pageDescription))
                        <p class="mt-1 text-sm text-gray-500">{{ $pageDescription }}</p>
                    @endif
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main>
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
                                                   {{ !request('categoryId') ? 'checked' : '' }}
                                                   onchange="filterProducts()"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="ml-3 text-sm text-gray-700">Tất cả sản phẩm</span>
                                            @if(isset($totalProducts))
                                                <span class="ml-auto text-xs text-gray-500">({{ $totalProducts }})</span>
                                            @endif
                                        </label>

                                        <!-- Categories dynamiques ou fixes -->
                                        @if(isset($categories) && $categories->count() > 0)
                                            @foreach($categories as $category)
                                                <label class="flex items-center">
                                                    <input type="radio" name="category" value="{{ $category->category_id }}" 
                                                           {{ request('categoryId') == $category->category_id ? 'checked' : '' }}
                                                           onchange="filterProducts()"
                                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                                    <span class="ml-3 text-sm text-gray-700">{{ $category->category_name }}</span>
                                                    @if($category->products)
                                                        <span class="ml-auto text-xs text-gray-500">({{ $category->products->count() }})</span>
                                                    @endif
                                                </label>
                                            @endforeach
                                        @else
                                            <!-- Fallback pour les catégories fixes -->
                                            <label class="flex items-center">
                                                <input type="radio" name="category" value="1" 
                                                       {{ request('categoryId') == '1' ? 'checked' : '' }}
                                                       onchange="filterProducts()"
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                                <span class="ml-3 text-sm text-gray-700">Áo thun</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="category" value="2" 
                                                       {{ request('categoryId') == '2' ? 'checked' : '' }}
                                                       onchange="filterProducts()"
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                                <span class="ml-3 text-sm text-gray-700">Áo sơ mi</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="category" value="3" 
                                                       {{ request('categoryId') == '3' ? 'checked' : '' }}
                                                       onchange="filterProducts()"
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                                <span class="ml-3 text-sm text-gray-700">Quần jeans</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="category" value="5" 
                                                       {{ request('categoryId') == '5' ? 'checked' : '' }}
                                                       onchange="filterProducts()"
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                                <span class="ml-3 text-sm text-gray-700">Đầm váy</span>
                                            </label>
                                        @endif
                                    </div>
                                </div>

                                <!-- Price Range Filter -->
                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Khoảng giá</h4>
                                    <div class="space-y-2">
                                        @php
                                            $currentMinPrice = request('minPrice');
                                            $currentMaxPrice = request('maxPrice');
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
                                                   {{ request('inStock') === 'true' ? 'checked' : '' }}
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
                                        <select name="sort" onchange="handleSortChange(this.value)" 
                                                class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                            <option value="newest" {{ request('order') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                            <option value="oldest" {{ request('order') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                            <option value="priceUp" {{ request('order') == 'priceUp' ? 'selected' : '' }}>Giá tăng dần</option>
                                            <option value="priceDown" {{ request('order') == 'priceDown' ? 'selected' : '' }}>Giá giảm dần</option>
                                            <option value="name" {{ request('order') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Current Filters Display -->
                            @if(request()->hasAny(['categoryId', 'minPrice', 'maxPrice', 'inStock', 'order']))
                                <div class="mb-6">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-sm font-medium text-gray-700">Đang lọc:</span>
                                        
                                        @if(request('categoryId'))
                                            @php
                                                $categoryNames = [
                                                    '1' => 'Áo thun',
                                                    '2' => 'Áo sơ mi', 
                                                    '3' => 'Quần jeans',
                                                    '5' => 'Đầm váy'
                                                ];
                                                
                                                // Essayer d'utiliser les catégories dynamiques si disponibles
                                                if(isset($categories) && $categories->count() > 0) {
                                                    $currentCategoryFromQuery = $categories->where('category_id', request('categoryId'))->first();
                                                    $currentCategoryName = $currentCategoryFromQuery ? $currentCategoryFromQuery->category_name : ($categoryNames[request('categoryId')] ?? 'Không xác định');
                                                } else {
                                                    $currentCategoryName = $categoryNames[request('categoryId')] ?? 'Không xác định';
                                                }
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $currentCategoryName }}
                                                <button onclick="removeFilter('category')" class="ml-2 hover:text-blue-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </span>
                                        @endif

                                        @if(request('minPrice') !== null && request('maxPrice') !== null)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                Giá: {{ number_format(request('minPrice')) }}đ - {{ number_format(request('maxPrice')) }}đ
                                                <button onclick="removeFilter('price_range')" class="ml-2 hover:text-green-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </span>
                                        @endif

                                        @if(request('inStock') === 'true')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                Còn hàng
                                                <button onclick="removeFilter('in_stock')" class="ml-2 hover:text-yellow-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </span>
                                        @endif

                                        @if(request('order'))
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                                Sắp xếp: {{ ucfirst(request('order')) }}
                                                <button onclick="removeFilter('sort')" class="ml-2 hover:text-purple-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Products Content - Section pour le contenu spécifique -->
                            @yield('products-content')
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Filter JavaScript -->
    <script>
        // Khởi tạo trạng thái checkbox khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            
            // Set checkbox states based on URL parameters
            const inStockCheckbox = document.getElementById('inStockCheckbox');
            if (urlParams.get('inStock') === 'true') {
                inStockCheckbox.checked = true;
            }
            
            // Set category radio based on URL parameters
            const categoryId = urlParams.get('categoryId');
            if (categoryId) {
                const categoryRadio = document.querySelector(`input[name="category"][value="${categoryId}"]`);
                if (categoryRadio) {
                    categoryRadio.checked = true;
                }
            }
            
            // Set price range radio based on URL parameters
            const minPrice = urlParams.get('minPrice');
            const maxPrice = urlParams.get('maxPrice');
            if (minPrice && maxPrice) {
                let priceRangeValue = '';
                if (minPrice == 0 && maxPrice == 500000) {
                    priceRangeValue = '0-500000';
                } else if (minPrice == 500000 && maxPrice == 1000000) {
                    priceRangeValue = '500000-1000000';
                } else if (minPrice == 1000000 && maxPrice == 2000000) {
                    priceRangeValue = '1000000-2000000';
                } else if (minPrice == 2000000 && maxPrice == 999999999) {
                    priceRangeValue = '2000000+';
                }
                
                if (priceRangeValue) {
                    const priceRadio = document.querySelector(`input[name="price_range"][value="${priceRangeValue}"]`);
                    if (priceRadio) {
                        priceRadio.checked = true;
                    }
                }
            }
            
            // Set sort select based on URL parameters
            const order = urlParams.get('order');
            const sortSelect = document.querySelector('select[name="sort"]');
            if (order && sortSelect) {
                sortSelect.value = order;
            }
        });

        function filterProducts() {
            // Get current URL parameters to preserve existing filters
            const urlParams = new URLSearchParams(window.location.search);
            
            // Get current form values
            const category = document.querySelector('input[name="category"]:checked');
            const priceRange = document.querySelector('input[name="price_range"]:checked');
            const inStock = document.querySelector('input[name="in_stock"]:checked');
            const sortSelect = document.querySelector('select[name="sort"]');
            
            // Start with current parameters
            let params = new URLSearchParams(window.location.search);

            // Update category
            params.delete('categoryId');
            if (category && category.value) {
                params.set('categoryId', category.value);
            }

            // Update price range
            params.delete('minPrice');
            params.delete('maxPrice');
            if (priceRange && priceRange.value) {
                switch (priceRange.value) {
                    case '0-500000':
                        params.set('minPrice', 0);
                        params.set('maxPrice', 500000);
                        break;
                    case '500000-1000000':
                        params.set('minPrice', 500000);
                        params.set('maxPrice', 1000000);
                        break;
                    case '1000000-2000000':
                        params.set('minPrice', 1000000);
                        params.set('maxPrice', 2000000);
                        break;
                    case '2000000+':
                        params.set('minPrice', 2000000);
                        params.set('maxPrice', 999999999);
                        break;
                }
            }

            // Update in stock
            params.delete('inStock');
            if (inStock && inStock.checked) {
                params.set('inStock', 'true');
            }

            // Update sort/order
            params.delete('order');
            if (sortSelect && sortSelect.value && sortSelect.value !== 'newest') {
                params.set('order', sortSelect.value);
            }

            window.location.href = '/products?' + params.toString();
        }

        // Đổi hàm onchange của select sort:
        function handleSortChange(value) {
            filterProducts();
        }

        function clearFilters() {
            window.location.href = '/products';
        }
        
        function removeFilter(filterName) {
            const urlParams = new URLSearchParams(window.location.search);
            
            switch(filterName) {
                case 'category':
                    urlParams.delete('categoryId');
                    break;
                case 'price_range':
                    urlParams.delete('minPrice');
                    urlParams.delete('maxPrice');
                    break;
                case 'in_stock':
                    urlParams.delete('inStock');
                    break;
                case 'sort':
                    urlParams.delete('order');
                    break;
            }
            
            const queryString = urlParams.toString();
            if (queryString) {
                window.location.href = '/products?' + queryString;
            } else {
                window.location.href = '/products';
            }
        }
    </script>

    @stack('scripts')
</body>
</html>