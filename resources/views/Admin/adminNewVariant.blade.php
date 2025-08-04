@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8 max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Thêm biến thể mới</h1>
    </div>

    <!-- Modal thông báo thành công -->
    @if(session('success'))
        <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
            <div class="bg-white rounded-lg shadow-lg p-8 max-w-sm w-full text-center">
                <svg class="mx-auto mb-4 h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <h2 class="text-xl font-semibold mb-2">{{ session('success') }}</h2>
                <button onclick="document.getElementById('successModal').classList.add('hidden')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Đóng</button>
            </div>
        </div>
        <script>
            setTimeout(function() {
                var modal = document.getElementById('successModal');
                if(modal) modal.classList.add('hidden');
            }, 2500);
        </script>
    @endif

    <form method="POST" action="{{ route('admin.variants.store') }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 space-y-6">
        @csrf
        @if(request('product_id') || $product_id ?? null)
            <!-- Nếu có product_id từ URL hoặc route parameter, ẩn dropdown và hiển thị thông tin sản phẩm -->
            @php
                $productId = request('product_id') ?? ($product_id ?? null);
                $selectedProduct = $products->firstWhere('product_id', $productId);
            @endphp
            @if($selectedProduct)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sản phẩm</label>
                    <div class="p-3 bg-gray-50 border border-gray-300 rounded-md">
                        <span class="font-medium">{{ $selectedProduct->product_name }}</span>
                    </div>
                    <input type="hidden" name="product_id" value="{{ $selectedProduct->product_id }}">
                </div>
            @else
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Sản phẩm</label>
                    <select name="product_id" id="product_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Chọn sản phẩm</option>
                        @foreach($products as $product)
                            <option value="{{ $product->product_id }}" {{ $productId == $product->product_id ? 'selected' : '' }}>
                                {{ $product->product_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        @else
            <!-- Nếu không có product_id, hiển thị dropdown bình thường -->
            <div>
                <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Sản phẩm</label>
                <select name="product_id" id="product_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Chọn sản phẩm</option>
                    @foreach($products as $product)
                        <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div>
            <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
            <input type="text" name="sku" id="sku" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>
            <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Màu sắc</label>
            <input type="text" name="color" id="color" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Size</label>
            <input type="text" name="size" id="size" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Giá</label>
            <input type="number" name="price" id="price" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>
            <label for="compare_at_price" class="block text-sm font-medium text-gray-700 mb-1">Giá so sánh (compare_at_price)</label>
            <input type="number" name="compare_at_price" id="compare_at_price" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Số lượng</label>
            <input type="number" name="quantity" id="quantity" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>
            <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Ảnh biến thể</label>
            <input type="file" name="images[]" id="images" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" multiple>
            <p class="text-sm text-gray-500 mt-1">Có thể chọn nhiều ảnh cùng lúc</p>
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
            <textarea name="description" id="description" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>
        <div>
            <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
            <select name="is_active" id="is_active" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
        </div>
        <div class="flex justify-between items-center mt-6">
            @if($productId)
                <a href="{{ route('admin.products.variants', ['id' => $productId]) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Quay lại</a>
            @else
                <a href="{{ route('admin.products.showAll') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Quay lại</a>
            @endif
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Thêm biến thể</button>
        </div>
    </form>
</div>
@endsection
