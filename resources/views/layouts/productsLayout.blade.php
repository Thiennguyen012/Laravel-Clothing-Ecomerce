@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">


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
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-3 text-sm text-gray-700">Tất cả sản phẩm</span>
                                        @if(isset($totalProducts))
                                            <span class="ml-auto text-xs text-gray-500">({{ $totalProducts }})</span>
                                        @endif
                                    </label>

                                    <!-- Categories dynamic from $categories -->
                                    @if(isset($categories) && $categories->count() > 0)
                                        @foreach($categories as $category)
                                            <label class="flex items-center">
                                                <input type="radio" name="category" value="{{ $category->category_id }}" 
                                                       {{ request('categoryId') == $category->category_id ? 'checked' : '' }}
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
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-3 text-sm text-gray-700">Tất cả</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="price_range" value="0-500000" 
                                               {{ (request('price_range') == '0-500000') || ($currentPriceRange == '0-500000') ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-3 text-sm text-gray-700">Dưới 500.000đ</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="price_range" value="500000-1000000" 
                                               {{ (request('price_range') == '500000-1000000') || ($currentPriceRange == '500000-1000000') ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-3 text-sm text-gray-700">500.000đ - 1.000.000đ</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="price_range" value="1000000-2000000" 
                                               {{ (request('price_range') == '1000000-2000000') || ($currentPriceRange == '1000000-2000000') ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-3 text-sm text-gray-700">1.000.000đ - 2.000.000đ</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="price_range" value="2000000+" 
                                               {{ (request('price_range') == '2000000+') || ($currentPriceRange == '2000000+') ? 'checked' : '' }}
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
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="ml-3 text-sm text-gray-700">Còn hàng</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Filter & Clear Buttons -->
                            <div class="pt-4 border-t border-gray-200 flex flex-col gap-2">
                                <button type="button" onclick="applyFilters()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">Lọc</button>
                                <button type="button" onclick="clearFilters()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors duration-200">
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

                        <!-- Hiển thị các filter đang dùng -->
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
                        @yield('products-content')
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
function applyFilters() {
    // Lấy giá trị các filter
    var category = document.querySelector('input[name="category"]:checked');
    var priceRange = document.querySelector('input[name="price_range"]:checked');
    var inStock = document.getElementById('inStockCheckbox');
    var params = new URLSearchParams(window.location.search);
    // Danh mục
    if (category) {
        if (category.value) {
            params.set('categoryId', category.value);
        } else {
            params.delete('categoryId');
        }
    }
    // Giá
    if (priceRange) {
        var val = priceRange.value;
        if (val === '') {
            params.delete('price_range');
            params.delete('minPrice');
            params.delete('maxPrice');
        } else {
            params.set('price_range', val);
            if (val === '0-500000') {
                params.set('minPrice', 0);
                params.set('maxPrice', 500000);
            } else if (val === '500000-1000000') {
                params.set('minPrice', 500000);
                params.set('maxPrice', 1000000);
            } else if (val === '1000000-2000000') {
                params.set('minPrice', 1000000);
                params.set('maxPrice', 2000000);
            } else if (val === '2000000+') {
                params.set('minPrice', 2000000);
                params.set('maxPrice', 999999999);
            }
        }
    }
    // Còn hàng
    if (inStock && inStock.checked) {
        params.set('inStock', 'true');
    } else {
        params.delete('inStock');
    }
    // Reset page về 1 khi lọc
    params.set('page', 1);
    // Giữ các tham số khác (order, search...)
    window.location.search = params.toString();
}

function clearFilters() {
    // Xóa tất cả filter parameters
    var params = new URLSearchParams(window.location.search);
    params.delete('categoryId');
    params.delete('price_range');
    params.delete('minPrice');
    params.delete('maxPrice');
    params.delete('inStock');
    params.delete('order');
    params.set('page', 1);
    window.location.search = params.toString();
}

function removeFilter(filterType) {
    var params = new URLSearchParams(window.location.search);
    switch(filterType) {
        case 'category':
            params.delete('categoryId');
            break;
        case 'price_range':
            params.delete('price_range');
            params.delete('minPrice');
            params.delete('maxPrice');
            break;
        case 'in_stock':
            params.delete('inStock');
            break;
        case 'sort':
            params.delete('order');
            break;
    }
    params.set('page', 1);
    window.location.search = params.toString();
}

function handleSortChange(sortValue) {
    var params = new URLSearchParams(window.location.search);
    if (sortValue) {
        params.set('order', sortValue);
    } else {
        params.delete('order');
    }
    params.set('page', 1);
    window.location.search = params.toString();
}
</script>
@stack('scripts')
@endsection