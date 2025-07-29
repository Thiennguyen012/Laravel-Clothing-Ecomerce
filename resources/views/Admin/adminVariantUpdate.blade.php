@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Cập nhật biến thể sản phẩm</h1>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.products.updateVariant', ['id' => $variant->variant_id ?? $variant->id]) }}" method="POST" class="bg-white shadow rounded-lg p-6 max-w-lg mx-auto">
        @csrf
        @method('POST')
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $variant->sku ?? '') }}" class="w-full border-gray-300 rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Màu sắc</label>
            <input type="text" name="color" value="{{ old('color', $variant->color ?? '') }}" class="w-full border-gray-300 rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Size</label>
            <input type="text" name="size" value="{{ old('size', $variant->size ?? '') }}" class="w-full border-gray-300 rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Giá</label>
            <input type="number" name="price" value="{{ old('price', $variant->price ?? '') }}" class="w-full border-gray-300 rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Số lượng</label>
            <input type="number" name="quantity" value="{{ old('quantity', $variant->quantity ?? '') }}" class="w-full border-gray-300 rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Trạng thái</label>
            <select name="is_active" class="w-full border-gray-300 rounded px-3 py-2">
                <option value="1" {{ (old('is_active', $variant->is_active ?? 1) == 1) ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ (old('is_active', $variant->is_active ?? 1) == 0) ? 'selected' : '' }}>Ẩn</option>
            </select>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Quay lại</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
