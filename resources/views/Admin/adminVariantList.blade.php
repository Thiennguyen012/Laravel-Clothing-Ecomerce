@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Chi tiết sản phẩm: {{ $products->product_name ?? '' }}</h1>
    <div class="mb-4">
        <span class="text-gray-700 font-semibold">Danh mục:</span> {{ $products->category->category_name ?? '-' }}<br>
        <span class="text-gray-700 font-semibold">Mô tả:</span> {{ $products->description ?? '-' }}
    </div>

    <div class="flex justify-start mb-4">
        <a href="{{ route('admin.variants.newVariantForProduct', ['product_id' => $products->product_id ?? $products->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Thêm biến thể mới
        </a>
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
                            <button type="button" class="text-red-600 hover:underline bg-transparent border-none p-0 m-0 cursor-pointer" onclick="showDeleteVariantModal({{ $variant->id }}, '{{ $variant->sku }}')">Xóa</button>
                            <form id="delete-variant-form-{{ $variant->id }}" action="{{ route('admin.variants.delete', ['id' => $variant->id]) }}" method="POST" style="display:none">
                                @csrf
                                @method('DELETE')
                            </form>
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

<!-- Modal xác nhận xóa variant -->
<div id="deleteVariantConfirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">Xác nhận xóa biến thể</h2>
        <p id="deleteVariantModalText" class="mb-6">Bạn có chắc chắn muốn xóa biến thể này?</p>
        <div class="flex justify-end gap-2">
            <button onclick="hideDeleteVariantModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Hủy</button>
            <button id="confirmDeleteVariantBtn" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Xóa</button>
        </div>
    </div>
</div>

<!-- Modal thông báo xóa thành công -->
@if(session('delete_variant_success'))
<div id="deleteVariantSuccessModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md text-center">
        <h2 class="text-lg font-semibold mb-4 text-green-600">Xóa biến thể thành công!</h2>
        <button onclick="document.getElementById('deleteVariantSuccessModal').style.display='none'" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mt-4">Đóng</button>
    </div>
</div>
@endif

<script>
let deleteVariantId = null;
function showDeleteVariantModal(variantId, sku) {
    deleteVariantId = variantId;
    document.getElementById('deleteVariantModalText').innerText = `Bạn có chắc chắn muốn xóa biến thể SKU "${sku}"?`;
    document.getElementById('deleteVariantConfirmModal').style.display = 'flex';
}
function hideDeleteVariantModal() {
    document.getElementById('deleteVariantConfirmModal').style.display = 'none';
    deleteVariantId = null;
}
document.addEventListener('DOMContentLoaded', function() {
    const confirmBtn = document.getElementById('confirmDeleteVariantBtn');
    if (confirmBtn) {
        confirmBtn.onclick = function() {
            if (deleteVariantId) {
                document.getElementById('deleteVariantConfirmModal').style.display = 'none';
                document.getElementById('delete-variant-form-' + deleteVariantId).submit();
            }
        }
    }
});
</script>

@endsection
