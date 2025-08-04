<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight vietnamese-text">
            {{ __('Giỏ hàng') }}
        </h2>
    </x-slot>
    
    <style>
        .vietnamese-text {
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .cart-notification {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            min-width: 300px;
            text-align: center;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900 mb-8 vietnamese-text">Thông tin giỏ hàng</h1>
                    
                    <!-- Cart Items Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Cart Items -->
                        <div class="lg:col-span-2">
                            @if($cartItems && $cartItems->count() > 0)
                                <div class="space-y-6">
                                    @foreach($cartItems as $item)
                                        <div class="flex flex-col md:flex-row md:items-center justify-between p-4 md:p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                            <div class="flex items-center space-x-4 mb-4 md:mb-0">
                                                <!-- Product Image -->
                                                <div class="flex-shrink-0">
                                                    @php
                                                        $imagePath = null;
                                                        if(isset($item->variant->images) && trim($item->variant->images) !== '') {
                                                            $imagePath = asset('storage/' . ltrim($item->variant->images, '/'));
                                                        } elseif(isset($item->variant->product->images) && trim($item->variant->product->images) !== '') {
                                                            $imagePath = asset('storage/' . ltrim($item->variant->product->images, '/'));
                                                        } else {
                                                            $imagePath = asset('images/placeholder.jpg');
                                                        }
                                                    @endphp
                                                    <img class="h-16 w-16 md:h-20 md:w-20 rounded-md object-cover" 
                                                         src="{{ $imagePath }}" 
                                                         alt="{{ $item->variant->product->product_name ?? 'Product' }}">
                                                </div>
                                                
                                                <!-- Product Details -->
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="text-base md:text-lg font-medium text-gray-900 vietnamese-text">
                                                        {{ $item->variant->product->product_name ?? 'Sản phẩm' }}
                                                    </h3>
                                                    <p class="text-xs md:text-sm text-gray-500 vietnamese-text">
                                                        Size: {{ $item->variant->size ?? 'N/A' }} | Color: {{ $item->variant->color ?? 'N/A' }}
                                                    </p>
                                                    <p class="text-base md:text-lg font-semibold text-blue-600 vietnamese-text">
                                                        {{ number_format($item->price ?? 0, 0, ',', '.') }}đ
                                                    </p>
                                                </div>
                                            </div>
                                                
                                            <div class="flex items-center justify-between md:justify-end md:space-x-4">
                                                <!-- Quantity Controls -->
                                                <div class="flex items-center space-x-2">
                                                    <button onclick="updateQuantity({{ $item->variant_id }}, {{ $item->quantity - 1 }})" 
                                                            class="p-1 rounded-md border border-gray-300 hover:bg-gray-50"
                                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <span class="px-3 py-1 text-sm font-medium vietnamese-text">{{ $item->quantity ?? 1 }}</span>
                                                    <button onclick="updateQuantity({{ $item->variant_id }}, {{ $item->quantity + 1 }})" 
                                                            class="p-1 rounded-md border border-gray-300 hover:bg-gray-50">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                
                                                <!-- Remove Button -->
                                                <button onclick="removeItem({{ $item->variant_id }})" 
                                                        class="p-2 text-red-600 hover:text-red-800">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <!-- Empty Cart -->
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6M7 13h10M9 19a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 vietnamese-text">Giỏ hàng trống</h3>
                                    <p class="mt-1 text-sm text-gray-500 vietnamese-text">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('products') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 vietnamese-text">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Tiếp tục mua sắm
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Order Summary -->
                        @if($cartItems && $cartItems->count() > 0)
                            <div class="lg:col-span-1">
                                <div class="bg-gray-50 p-6 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4 vietnamese-text">Tóm tắt đơn hàng</h3>
                                    
                                    <div class="space-y-3">
                                        <div class="flex justify-between text-sm vietnamese-text">
                                            <span>Tạm tính:</span>
                                            <span>{{ number_format($total ?? 0, 0, ',', '.') }}đ</span>
                                        </div>
                                        <div class="flex justify-between text-sm vietnamese-text">
                                            <span>Phí vận chuyển:</span>
                                            <span>0đ</span>
                                        </div>
                                        <div class="border-t border-gray-200 pt-3">
                                            <div class="flex justify-between text-base font-medium vietnamese-text">
                                                <span>Tổng cộng:</span>
                                                <span>{{ number_format(($total ?? 0) + 0, 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6">
                                        <a href="{{ route('checkout') }}" class="w-full bg-blue-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 block text-center vietnamese-text">
                                            Thanh toán
                                        </a>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <a href="{{ route('products') }}" class="w-full bg-white border border-gray-300 rounded-md shadow-sm py-3 px-4 text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 block text-center vietnamese-text">
                                            Tiếp tục mua sắm
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/cart.js'])
</x-app-layout>
