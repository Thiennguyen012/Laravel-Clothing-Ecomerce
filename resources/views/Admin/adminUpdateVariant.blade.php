@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8 max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Cập nhật biến thể</h1>
    </div>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.variants.updateVariant', ['id' => $variant->variant_id ?? $variant->id]) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 max-w-2xl mx-auto">
        @csrf
        @method('POST')
        <input type="hidden" name='variant_id' value="{{ $variant->id }}">
        <input type="hidden" name='product_id' value="{{ $variant->product_id }}">
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $variant->sku ?? '') }}" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Màu sắc</label>
            <input type="text" name="color" value="{{ old('color', $variant->color ?? '') }}" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Size</label>
            <input type="text" name="size" value="{{ old('size', $variant->size ?? '') }}" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Giá</label>
            <input type="number" name="price" value="{{ old('price', $variant->price ?? '') }}" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Giá so sánh (compare_at_price)</label>
            <input type="number" name="compare_at_price" value="{{ old('compare_at_price', $variant->compare_at_price ?? '') }}" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Số lượng</label>
            <input type="number" name="quantity" value="{{ old('quantity', $variant->quantity ?? '') }}" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Ảnh biến thể</label>
            <input type="file" name="images[]" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2" multiple>
            <p class="text-sm text-gray-500 mt-1">Có thể chọn nhiều ảnh cùng lúc</p>
            @if(!empty($variant->images))
                <div class="mt-2">
                    <p class="text-sm text-gray-600 mb-2">Ảnh hiện tại:</p>
                    <div class="flex flex-wrap gap-2">
                        <img src="{{ asset('storage/' . $variant->images) }}" alt="Ảnh" class="w-16 h-16 object-cover rounded border">
                    </div>
                </div>
            @endif
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Mô tả</label>
            <textarea name="description" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2" rows="2">{{ old('description', $variant->description ?? '') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Trạng thái</label>
            <select name="is_active" class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                <option value="1" {{ (old('is_active', $variant->is_active ?? 1) == 1) ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ (old('is_active', $variant->is_active ?? 1) == 0) ? 'selected' : '' }}>Ẩn</option>
            </select>
        </div>
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.products.variants', ['id' => $variant->product_id]) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Quay lại</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
