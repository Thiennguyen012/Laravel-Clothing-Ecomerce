@extends('layouts.productsLayout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Sản phẩm
    </h2>
@endsection

@push('scripts')
    @vite(['resources/js/products.js'])
@endpush

@section('products-content')
    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($products as $item)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden group cursor-pointer"
                 onclick="window.location.href='{{ route('product.show', $item->product_id) }}'">
                <!-- Product Image -->
                {{-- {{ dd($item->images) }} --}}
                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200">
                    @if(!empty($item->images))
                        <img src="{{ asset('storage/' . $item->images) }}" 
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


    <!-- Pagination -->
    @if ($products->hasPages())
        <div class="mt-8 flex flex-col items-center">
            <div class="flex items-center space-x-2">
                {{-- Previous Page Link --}}
                @if ($products->onFirstPage())
                    <span class="px-3 py-2 rounded-md bg-gray-200 text-gray-400 cursor-not-allowed">&lt;</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-blue-100 transition">&lt;</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if ($page == $products->currentPage())
                        <span class="px-3 py-2 rounded-md bg-blue-600 text-white font-semibold border border-blue-600">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-blue-100 transition">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-blue-100 transition">&gt;</a>
                @else
                    <span class="px-3 py-2 rounded-md bg-gray-200 text-gray-400 cursor-not-allowed">&gt;</span>
                @endif
            </div>
            <div class="mt-2 text-sm text-gray-500">
                Hiển thị {{ ($products->currentPage() - 1) * $products->perPage() + 1 }}
                đến {{ ($products->currentPage() - 1) * $products->perPage() + $products->count() }}
                trong tổng số {{ $products->total() }} sản phẩm
            </div>
        </div>
    @endif

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

    <!-- JavaScript spécifique aux produits -->
    <script>
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
    </script>
@endsection