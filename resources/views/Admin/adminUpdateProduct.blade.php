@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8 max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Cập nhật sản phẩm</h1>
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
            // Tự động đóng modal sau 2.5s
            setTimeout(function() {
                var modal = document.getElementById('successModal');
                if(modal) modal.classList.add('hidden');
            }, 2500);
        </script>
    @endif
    <form method="POST" action="{{ route('admin.products.update',['id' => $product->product_id])  }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 max-w-2xl mx-auto">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
        <div class="mb-4">
            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Tên sản phẩm</label>
            <input type="text" name="product_name" id="product_name" value="{{ old('product_name', $product->product_name) }}" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2 px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
            <select name="category_id" id="category_id" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}" {{ $product->category_id == $cat->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
            <textarea name="description" id="description" rows="4" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
            <select name="is_active" id="is_active" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                <option value="1" {{ $product->is_active ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Ẩn</option>
            </select>
        </div>
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.products.view') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Quay lại</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
