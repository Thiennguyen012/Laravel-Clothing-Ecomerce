@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Chi tiết sản phẩm: {{ $products->product_name ?? '' }}</h1>
    <div class="mb-4">
        <span class="text-gray-700 font-semibold">Danh mục:</span> {{ $products->category->category_name ?? '-' }}<br>
        <span class="text-gray-700 font-semibold">Mô tả:</span> {{ $products->description ?? '-' }}
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tên biến thể</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Giá</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products->variants as $variant)
                    <tr>
                        <td class="px-4 py-2">{{ $variant->variant_id ?? $variant->id }}</td>
                        <td class="px-4 py-2">{{ $variant->variant_name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ number_format($variant->price, 0, ',', '.') }} VNĐ</td>
                        <td class="px-4 py-2">{{ $variant->quantity }}</td>
                        <td class="px-4 py-2">{{ $variant->sku ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @if($variant->quantity > 0)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Còn hàng</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Hết hàng</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Không có biến thể nào cho sản phẩm này.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
