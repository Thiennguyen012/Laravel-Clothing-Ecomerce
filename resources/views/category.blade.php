@extends('layouts.products')

@php
    $pageTitle = 'Sản phẩm theo danh mục';
    if(isset($currentCategory)) {
        $pageTitle = $currentCategory->category_name;
        $pageDescription = $currentCategory->description ?? 'Khám phá các sản phẩm tuyệt vời trong danh mục này';
    }
@endphp

@section('products-content')
    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($products as $item)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                <!-- Product Image -->
                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200">
                    @if($item->images)
                        <img src="{{ $item->images }}" 
                             alt="{{ $item->product_name }}" 
                             class="h-48 w-full object-cover object-center group-hover:opacity-75">
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
                        <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-md transition-colors duration-200">
                            Xem chi tiết
                        </button>
                        @if($hasStock)
                            <button class="flex-1 bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded-md transition-colors duration-200">
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
                @if(isset($currentCategory))
                    Danh mục "{{ $currentCategory->category_name }}" hiện chưa có sản phẩm nào.
                @else
                    Không tìm thấy sản phẩm nào trong danh mục này.
                @endif
            </p>
            <div class="mt-4">
                <a href="{{ route('products') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-600 bg-blue-100 hover:bg-blue-200">
                    Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    @endif
@endsection
