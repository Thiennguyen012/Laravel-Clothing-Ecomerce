@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Chi tiết sản phẩm: {{ $products->product_name ?? '' }}</h1>
    <div class="mb-4">
        <span class="text-gray-700 font-semibold">Danh mục:</span> {{ $products->category->category_name ?? '-' }}<br>
        <span class="text-gray-700 font-semibold">Mô tả:</span> {{ $products->description ?? '-' }}
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        @php
            $sort = request('sort', '');
            $direction = request('direction', 'asc');
            function sortUrlVariant($column) {
                $currentSort = request('sort', '');
                $currentDirection = request('direction', 'asc');
                $newDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
                return request()->fullUrlWithQuery(['sort' => $column, 'direction' => $newDirection]);
            }
            function sortIconVariant($column) {
                $currentSort = request('sort', '');
                $currentDirection = request('direction', 'asc');
                if ($currentSort === $column) {
                    return $currentDirection === 'asc' ? '▲' : '▼';
                }
                return '';
            }
        @endphp
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlVariant('id') }}" class="flex items-center gap-1">
                            ID <span class="text-xs">{{ sortIconVariant('id') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlVariant('sku') }}" class="flex items-center gap-1">
                            SKU <span class="text-xs">{{ sortIconVariant('sku') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlVariant('color') }}" class="flex items-center gap-1">
                            Màu sắc <span class="text-xs">{{ sortIconVariant('color') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlVariant('size') }}" class="flex items-center gap-1">
                            Size <span class="text-xs">{{ sortIconVariant('size') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlVariant('price') }}" class="flex items-center gap-1">
                            Giá <span class="text-xs">{{ sortIconVariant('price') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlVariant('quantity') }}" class="flex items-center gap-1">
                            Số lượng <span class="text-xs">{{ sortIconVariant('quantity') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlVariant('is_active') }}" class="flex items-center gap-1">
                            Trạng thái <span class="text-xs">{{ sortIconVariant('is_active') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlVariant('updated_at') }}" class="flex items-center gap-1">
                            Ngày cập nhật <span class="text-xs">{{ sortIconVariant('updated_at') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($variants as $variant)
                    <tr>
                        <td class="px-4 py-2">{{ $variant->id }}</td>
                        <td class="px-4 py-2">{{ $variant->sku ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $variant->color ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $variant->size ?? '-' }}</td>
                        <td class="px-4 py-2">{{ number_format($variant->price, 0, ',', '.') }} VNĐ</td>
                        <td class="px-4 py-2">{{ $variant->quantity }}</td>
                        <td class="px-4 py-2">
                            @if($variant->is_active ?? true)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Hiển thị</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-600">Ẩn</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $variant->updated_at ? $variant->updated_at->format('d/m/Y H:i') : '-' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.variants.updateVariant',['id' => $variant->id]) }}" class="text-blue-600 hover:underline mr-2">Sửa</a>
                            <a href="#" class="text-red-600 hover:underline">Xóa</a>
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
