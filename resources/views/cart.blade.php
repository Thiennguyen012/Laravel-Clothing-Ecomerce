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
                    
                    @if($cartItems && $cartItems->count() > 0)
                        <!-- Cart Items Section -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Cart Items -->
                            <div class="lg:col-span-2">
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
                                                <button onclick="showDeleteModal({{ $item->variant_id }})" 
                                                        class="p-2 text-red-600 hover:text-red-800">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Order Summary -->
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
                        </div>
                    @else
                        <!-- Empty Cart - Centered -->
                        <div class="flex items-center justify-center min-h-[400px]">
                            <div class="text-center">
                                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6M7 13h10M9 19a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z"></path>
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-900 vietnamese-text">Giỏ hàng trống</h3>
                                <p class="mt-2 text-sm text-gray-500 vietnamese-text">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                                <div class="mt-6">
                                    <a href="{{ route('products') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 vietnamese-text">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
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
    <!-- Modal Confirm Delete -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden flex items-center justify-center">
        <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 vietnamese-text mt-4">Xác nhận xóa sản phẩm</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 vietnamese-text">
                        Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button onclick="confirmDelete()" id="confirm-delete" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 vietnamese-text">
                        Xóa
                    </button>
                    <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 vietnamese-text">
                        Hủy
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="cart-toast" class="fixed top-6 right-6 z-50 hidden min-w-[300px] bg-green-500 text-white px-6 py-4 rounded shadow-lg flex items-center space-x-3">
        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span id="cart-toast-message">Cập nhật số lượng thành công!</span>
        <button onclick="document.getElementById('cart-toast').classList.add('hidden')" class="ml-auto text-white hover:text-gray-200">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    @vite(['resources/js/cart.js'])
</x-app-layout>
