    @vite(['resources/js/products.js'])
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sản phẩm
        </h2>
    </x-slot>

    {{-- <style>
        .product-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
        
        .sticky-cart-button {
            transition: all 0.3s ease;
        }
        
        .sticky-cart-button:hover {
            transform: scale(1.1);
        }
        
        /* Notification styles */
        .notification-enter {
            transform: translateX(100%);
            opacity: 0;
        }
        
        .notification-enter-active {
            transform: translateX(0);
            opacity: 1;
            transition: all 0.3s ease;
        }
        
        .notification-exit {
            transform: translateX(0);
            opacity: 1;
        }
        
        .notification-exit-active {
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        /* Loading button animation */
        .loading-btn {
            position: relative;
            color: transparent !important;
        }
        
        .loading-btn::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Cart count animation */
        .cart-count-bounce {
            animation: bounce 0.5s ease-in-out;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
    </style> --}}

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
                                </label>

                                <!-- Categories -->
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
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Khoảng giá</h4>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="" 
                                           {{ !request('price_range') && !request('minPrice') ? 'checked' : '' }}
                                           onchange="filterProducts()"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-sm text-gray-700">Tất cả</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="0-500000" 
                                           {{ (request('price_range') == '0-500000') || (request('minPrice') == '0' && request('maxPrice') == '500000') ? 'checked' : '' }}
                                           onchange="filterProducts()"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-sm text-gray-700">Dưới 500.000đ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="500000-1000000" 
                                           {{ (request('price_range') == '500000-1000000') || (request('minPrice') == '500000' && request('maxPrice') == '1000000') ? 'checked' : '' }}
                                           onchange="filterProducts()"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-sm text-gray-700">500.000đ - 1.000.000đ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="1000000-2000000" 
                                           {{ (request('price_range') == '1000000-2000000') || (request('minPrice') == '1000000' && request('maxPrice') == '2000000') ? 'checked' : '' }}
                                           onchange="filterProducts()"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-sm text-gray-700">1.000.000đ - 2.000.000đ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="2000000+" 
                                           {{ (request('price_range') == '2000000+') || (request('minPrice') == '2000000' && request('maxPrice') == '999999999') ? 'checked' : '' }}
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
                                        $currentCategoryName = $categoryNames[request('categoryId')] ?? 'Không xác định';
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

                                @if(request('minPrice') && request('maxPrice'))
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

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($products as $item)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden group cursor-pointer"
                                 onclick="window.location.href='{{ route('product.show', $item->product_id) }}'">
                                <!-- Product Image -->
                                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200">
                                    @if($item->images)
                                        <img src="{{ $item->images }}" 
                                             alt="{{ $item->product_name }}" 
                                             class="h-48 w-full object-cover object-center group-hover:opacity-75 transition-opacity duration-300">
                                    @else
                                        <div class="h-48 w-full bg-gray-300 flex items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                
                                <!-- Product Info -->
                                <div class="p-4">
                                    <!-- Product Name -->
                                    <h4 class="text-lg font-medium text-gray-900 mb-2 line-clamp-2">
                                        {{ $item->product_name }}
                                    </h4>

                                    <!-- Description -->
                                    @if($item->description)
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                            {{ Str::limit($item->description, 80) }}
                                        </p>
                                    @endif

                                    <!-- Price -->
                                    <div class="flex items-center justify-between mb-3">
                                       @php
                                            // Tính giá từ variants hoặc product
                                            if($item->variants && $item->variants->count() > 0) {
                                                $minPrice = $item->variants->min('price');
                                                $maxPrice = $item->variants->max('price');
                                            } else {
                                                $minPrice = $item->price;
                                                $maxPrice = $item->price;
                                            }
                                        @endphp
        
                                        <span class="text-lg font-bold text-blue-600">
                                            @if($minPrice == $maxPrice)
                                                {{ number_format($minPrice, 0, ',', '.') }} VNĐ
                                            @else
                                                {{ number_format($minPrice, 0, ',', '.') }} - {{ number_format($maxPrice, 0, ',', '.') }} VNĐ
                                            @endif
                                        </span>
                                        
                                        <!-- Stock Status -->
                                        @php
                                            // Tính tổng stock từ variants hoặc product
                                            if($item->variants && $item->variants->count() > 0) {
                                                $totalStock = $item->variants->sum('quantity');
                                                $hasStock = $totalStock > 0;
                                            } else {
                                                $totalStock = $item->stock_quantity;
                                                $hasStock = $item->stock_quantity > 0;
                                            }
                                        @endphp
                                        <span class="px-2 py-1 text-xs rounded-full {{ $hasStock ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $hasStock ? 'Còn hàng' : 'Hết hàng' }}
                                        </span>
                                    </div>

                                    <!-- Stock Quantity -->
                                    <p class="text-sm text-gray-500 mb-3">
                                        @if($item->variants && $item->variants->count() > 0)
                                            Tổng số lượng: {{ $totalStock }}
                                            @php $availableVariants = $item->variants->where('quantity', '>', 0)->count(); @endphp
                                            @if($availableVariants > 0)
                                                <span class="text-xs text-green-600">({{ $availableVariants }}/{{ $item->variants->count() }} biến thể còn hàng)</span>
                                            @else
                                                <span class="text-xs text-red-600">(Tất cả biến thể hết hàng)</span>
                                            @endif
                                        @else
                                            Số lượng: {{ $totalStock }}
                                        @endif
                                    </p>
                                
                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('product.show', $item->product_id) }}" 
                                           onclick="event.stopPropagation()"
                                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-md transition-colors duration-200 text-center">
                                            Xem chi tiết
                                        </a>
                                        @php
                                            $variantId = null;
                                            $variantPrice = null;
                                            $hasAvailableVariant = false;
                                            if($item->variants && $item->variants->count() > 0) {
                                                $availableVariants = $item->variants->where('quantity', '>', 0);
                                                $hasAvailableVariant = $availableVariants->count() > 0;
                                                $minPriceVariant = $availableVariants->sortBy('price')->first();
                                                if($minPriceVariant) {
                                                    $variantId = $minPriceVariant->id ?? $minPriceVariant->variant_id;
                                                    $variantPrice = $minPriceVariant->price;
                                                }
                                            }
                                        @endphp
                                        @if((($item->variants && $item->variants->count() > 0 && $hasAvailableVariant) || (!$item->variants || $item->variants->count() == 0)) && $hasStock)
                                            <button onclick="event.stopPropagation(); addToCart({{ $variantId ? $variantId : $item->product_id }}, {{ $variantPrice !== null ? $variantPrice : $item->price }})"
                                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded-md transition-colors duration-200">
                                                Thêm vào giỏ
                                            </button>
                                        @else
                                            <button class="flex-1 bg-gray-400 text-white text-sm font-medium py-2 px-4 rounded-md cursor-not-allowed" disabled>
                                                Hết hàng
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Empty State -->
                    @if($products->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m14 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m14 0H6m14 0l-3-3m3 3l-3 3M6 13l3-3m-3 3l3 3" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Không có sản phẩm</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request()->hasAny(['category', 'price_range', 'in_stock']))
                                    Không tìm thấy sản phẩm phù hợp với bộ lọc hiện tại.
                                @else
                                    Chưa có sản phẩm nào được thêm vào hệ thống.
                                @endif
                            </p>
                            @if(request()->hasAny(['category', 'price_range', 'in_stock']))
                                <div class="mt-4">
                                    <button onclick="clearFilters()" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-600 bg-blue-100 hover:bg-blue-200">
                                        Xóa bộ lọc
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
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

        // Function to handle add to cart
        function addToCart(variantId, price) {
            // Hiển thị loading
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Đang thêm...';
            button.disabled = true;

            // Lấy CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    variant_id: variantId,
                    quantity: 1,
                    price: price
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Add to cart response:', data); // Debug log
                if (data.success) {
                    // Hiển thị thông báo thành công
                    showNotification('success', data.message);
                    updateCartCount(data.cart_count);
                } else {
                    console.error('Add to cart failed:', data); // Debug log
                    showNotification('error', data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Add to cart error:', error);
                showNotification('error', 'Không thể thêm sản phẩm vào giỏ hàng');
            })
            .finally(() => {
                button.textContent = originalText;
                button.disabled = false;
            });
        }

        // Function to show notification
        function showNotification(type, message) {
            // Tạo notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transition-all duration-300 transform translate-x-full`;
            
            if (type === 'success') {
                notification.className += ' bg-green-500 text-white';
            } else {
                notification.className += ' bg-red-500 text-white';
            }
            
            notification.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        ${type === 'success' ? 
                            '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
                            '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>'
                        }
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">${message}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-white hover:text-gray-200">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            
            // Thêm vào DOM
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 5000);
        }

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
                
                // Remove animation class after animation completes
                setTimeout(() => {
                    cartBadge.classList.remove('cart-count-bounce');
                }, 500);
            }
            
            // Update tooltip
            if (cartTooltip) {
                if (count > 0) {
                    cartTooltip.textContent = `Giỏ hàng (${count} sản phẩm)`;
                } else {
                    cartTooltip.textContent = 'Giỏ hàng (trống)';
                }
            }
        }

        // Advanced Add to Cart with Variant Selection
        function addToCartWithModal(productId, variants) {
            // Tạo modal để user chọn variant
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-50 overflow-y-auto';
            modal.innerHTML = `
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal()"></div>
                    <div class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                            Chọn tùy chọn sản phẩm
                        </h3>
                        <div id="variant-selection">
                            <!-- Variant options will be populated here -->
                        </div>
                        <div class="mt-6 flex space-x-3">
                            <button onclick="closeModal()" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                                Hủy
                            </button>
                            <button onclick="confirmAddToCart()" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            // Populate variants (này cần data từ backend)
            // Tạm thời dùng default variant
        }

        function closeModal() {
            const modal = document.querySelector('.fixed.inset-0.z-50');
            if (modal) {
                modal.remove();
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
                console.log('Cart count response:', data); // Debug log
                if (data.success) {
                    updateCartCount(data.count);
                } else {
                    console.log('Cart count failed:', data);
                }
            })
            .catch(error => {
                console.log('Could not load cart count:', error);
            });
        }

        // Initialize cart count when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Products page loaded, loading cart count...');
            loadCartCount();
        });

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
</x-app-layout>
