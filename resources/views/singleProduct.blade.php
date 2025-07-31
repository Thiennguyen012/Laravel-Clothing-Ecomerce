<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('products') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Chi tiết sản phẩm
                </h2>
            </div>
            <div class="flex items-center space-x-3">
                <button class="text-gray-500 hover:text-red-500 p-2 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
                <button class="text-gray-500 hover:text-blue-500 p-2 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </x-slot>

<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-start">
            <!-- Product Images -->
            <div class="aspect-w-1 aspect-h-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Main Image -->
                    <div class="relative">
                        @if(isset($product->images) && trim($product->images) !== '')
                            <img id="mainImage" 
                                 src="{{ asset('storage/' . ltrim($product->images, '/')) }}" 
                                 alt="{{ $product->product_name }}"
                                 class="w-full h-96 object-contain object-center bg-white">
                        @else
                            <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Stock Badge -->
                        @if($product->hasStock())
                            <span class="absolute top-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Còn hàng
                            </span>
                        @else
                            <span class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Hết hàng
                            </span>
                        @endif
                    </div>
                    
                    <!-- Thumbnail Images -->
                    {{-- Nếu sau này muốn hỗ trợ nhiều ảnh, có thể sửa lại đoạn này --}}
                </div>
            </div>

            <!-- Product Information -->
            <div class="mt-10 lg:mt-0">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <!-- Product Name & Category -->
                    <div class="mb-6">
                        @if($product->category)
                            <nav class="text-sm mb-2">
                                <span class="text-gray-500">Danh mục:</span>
                                <span class="text-blue-600 font-medium">{{ $product->category->category_name }}</span>
                            </nav>
                        @endif
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->product_name }}</h1>
                        <p class="text-sm text-gray-600">SKU: {{ $product->sku ?? 'N/A' }}</p>
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        @if($product->variants && $product->variants->count() > 0)
                            @php
                                $minPrice = $product->variants->min('price');
                                $maxPrice = $product->variants->max('price');
                            @endphp
                            @if($minPrice == $maxPrice)
                                <p class="text-3xl font-bold text-blue-600">
                                    {{ number_format($minPrice, 0, ',', '.') }}đ
                                </p>
                            @else
                                <p class="text-3xl font-bold text-blue-600">
                                    {{ number_format($minPrice, 0, ',', '.') }}đ - {{ number_format($maxPrice, 0, ',', '.') }}đ
                                </p>
                            @endif
                        @else
                            <p class="text-3xl font-bold text-blue-600">
                                {{ number_format($product->price, 0, ',', '.') }}đ
                            </p>
                        @endif
                    </div>

                    <!-- Product Variants -->
                    @if($product->variants && $product->variants->count() > 0)
                        @php
                            // Lấy danh sách sizes và colors từ variants
                            $sizes = $product->variants->pluck('size')->unique()->filter()->values();
                            $colors = $product->variants->pluck('color')->unique()->filter()->values();
                            
                            // Tạo mapping variants theo size và color
                            $variantMap = [];
                            foreach($product->variants as $variant) {
                                if($variant->size && $variant->color) {
                                    $variantMap[$variant->size][$variant->color] = $variant;
                                }
                            }
                        @endphp
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Lựa chọn sản phẩm</h3>
                            
                            <!-- Size Selection -->
                            @if($sizes->count() > 0)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($sizes as $size)
                                            @php
                                                $hasStock = $product->variants->where('size', $size)->where('quantity', '>', 0)->count() > 0;
                                            @endphp
                                            <button type="button" 
                                                    onclick="selectSize('{{ $size }}')"
                                                    data-size="{{ $size }}"
                                                    class="size-option px-4 py-2 border rounded-md text-sm font-medium transition-all duration-200
                                                           {{ $hasStock ? 'border-gray-300 text-gray-700 hover:border-blue-500 hover:text-blue-600 cursor-pointer' : 'border-gray-200 text-gray-400 cursor-not-allowed bg-gray-50' }}"
                                                    {{ $hasStock ? '' : 'disabled' }}>
                                                {{ $size }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Color Selection -->
                            @if($colors->count() > 0)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Màu sắc</label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($colors as $color)
                                            @php
                                                $hasStock = $product->variants->where('color', $color)->where('quantity', '>', 0)->count() > 0;
                                            @endphp
                                            <button type="button" 
                                                    onclick="selectColor('{{ $color }}')"
                                                    data-color="{{ $color }}"
                                                    class="color-option px-4 py-2 border rounded-md text-sm font-medium transition-all duration-200
                                                           {{ $hasStock ? 'border-gray-300 text-gray-700 hover:border-blue-500 hover:text-blue-600 cursor-pointer' : 'border-gray-200 text-gray-400 cursor-not-allowed bg-gray-50' }}"
                                                    {{ $hasStock ? '' : 'disabled' }}>
                                                {{ $color }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Selected Variant Info -->
                            <div id="selected-variant-info" class="hidden mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-blue-900">Đã chọn: <span id="selected-details"></span></p>
                                        <p class="text-sm text-blue-700">Còn lại: <span id="selected-stock"></span> sản phẩm</p>
                                    </div>
                                    <div class="text-lg font-bold text-blue-600" id="selected-price"></div>
                                </div>
                            </div>
                            
                            <!-- Hidden input to store selected variant -->
                            <input type="hidden" id="selected-variant-id" name="variant_id" value="">
                        </div>
                    @endif

                    <!-- Quantity Selector -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng</label>
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="decreaseQuantity()" 
                                    class="w-10 h-10 border border-gray-300 rounded-md flex items-center justify-center hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <input type="number" id="quantity" value="1" min="1" max="10" 
                                   class="w-20 text-center border border-gray-300 rounded-md py-2 focus:ring-blue-500 focus:border-blue-500">
                            <button type="button" onclick="increaseQuantity()" 
                                    class="w-10 h-10 border border-gray-300 rounded-md flex items-center justify-center hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button type="button" 
                                onclick="addToCartSingleProduct()"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md transition duration-200 ease-in-out transform hover:scale-105">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 9H19"></path>
                            </svg>
                            Thêm vào giỏ hàng
                        </button>

                        <!-- Modal chọn thiếu size/màu -->
                        <div id="chooseVariantModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-30 hidden">
                            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center">
                                <div class="flex justify-center mb-2">
                                    <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />
                                    </svg>
                                </div>
                                <div class="text-lg font-semibold mb-2">Vui lòng chọn đầy đủ size và màu sắc trước khi thêm vào giỏ hàng!</div>
                                <button onclick="document.getElementById('chooseVariantModal').classList.add('hidden')" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Đóng</button>
                            </div>
                        </div>
                        
                        <button type="button" 
                                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-md transition duration-200 ease-in-out">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Mua ngay
                        </button>
                    </div>

                    <!-- Product Info Tabs -->
                    <div class="mt-8">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8">
                                <button onclick="showTab('description')" 
                                        class="tab-button active whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Mô tả sản phẩm
                                </button>
                                <button onclick="showTab('specifications')" 
                                        class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Thông số kỹ thuật
                                </button>
                                <button onclick="showTab('reviews')" 
                                        class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Đánh giá
                                </button>
                            </nav>
                        </div>
                        
                        <div class="mt-4">
                            <!-- Description Tab -->
                            <div id="description-tab" class="tab-content">
                                <div class="prose max-w-none">
                                    @if($product->description)
                                        {!! nl2br(e($product->description)) !!}
                                    @else
                                        <p class="text-gray-500">Chưa có mô tả cho sản phẩm này.</p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Specifications Tab -->
                            <div id="specifications-tab" class="tab-content hidden">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <dt class="font-medium text-gray-900">SKU</dt>
                                            <dd class="text-gray-700">{{ $product->sku ?? 'N/A' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-900">Tổng số lượng</dt>
                                            <dd class="text-gray-700">{{ $product->total_stock }} sản phẩm</dd>
                                        </div>
                                        @if($product->category)
                                            <div>
                                                <dt class="font-medium text-gray-900">Danh mục</dt>
                                                <dd class="text-gray-700">{{ $product->category->category_name }}</dd>
                                            </div>
                                        @endif
                                        <div>
                                            <dt class="font-medium text-gray-900">Trạng thái</dt>
                                            <dd class="text-gray-700">
                                                @if($product->is_active)
                                                    <span class="text-green-600">Đang bán</span>
                                                @else
                                                    <span class="text-red-600">Ngưng bán</span>
                                                @endif
                                            </dd>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Reviews Tab -->
                            <div id="reviews-tab" class="tab-content hidden">
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.45L3 21l2.45-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500">Chưa có đánh giá nào cho sản phẩm này.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="mt-16">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Sản phẩm liên quan</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="group relative">
                                <div class="bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 transition-opacity">
                                    @php
                                        $relatedImage = null;
                                        if(isset($relatedProduct->images) && trim($relatedProduct->images) !== '') {
                                            $relatedImage = asset('storage/' . ltrim($relatedProduct->images, '/'));
                                        }
                                    @endphp
                                    @if($relatedImage)
                                        <img src="{{ $relatedImage }}"
                                             alt="{{ $relatedProduct->product_name }}"
                                             class="w-full h-48 object-center object-contain bg-white">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <h3 class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('product.show', $relatedProduct->product_id) }}">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $relatedProduct->product_name }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $relatedProduct->category->category_name ?? '' }}</p>
                                    <p class="mt-1 text-lg font-medium text-blue-600">
                                        {{ number_format($relatedProduct->min_price ?? $relatedProduct->price, 0, ',', '.') }}đ
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>


<!-- Inject variant data for JS -->
<script>window.variants = @json($product->variants ?? []);</script>
<!-- Modal thông báo thêm vào giỏ hàng thành công -->
<div id="addToCartSuccessModal" class="fixed top-8 left-1/2 z-50 -translate-x-1/2 hidden">
    <div class="flex items-center px-6 py-4 bg-green-500 text-white rounded-xl shadow-lg gap-3 min-w-[320px] animate-fade-in-up">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="font-semibold flex-1">Đã thêm sản phẩm vào giỏ hàng</span>
        <button onclick="closeAddToCartModal()" class="ml-2 text-white hover:text-gray-200 focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>

<script>
// Hiển thị modal khi thiếu size/màu
function showChooseVariantModal() {
    var modal = document.getElementById('chooseVariantModal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}
window.showChooseVariantModal = showChooseVariantModal;
</script>
@vite(['resources/js/singleProduct.js'])

<style>
@keyframes fade-in-up {
    0% { opacity: 0; transform: translateY(30px) scale(0.98); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}
.animate-fade-in-up {
    animation: fade-in-up 0.3s cubic-bezier(.4,0,.2,1);
}
</style>

<style>
    .aspect-w-1 {
        position: relative;
        padding-bottom: 100%;
    }
    .aspect-w-1 > * {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
</x-app-layout>
