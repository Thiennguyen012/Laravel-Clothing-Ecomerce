@extends('layouts.admin')

@section('content')

<div class="container mx-auto py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-4">Quản lý sản phẩm</h1>
        <form method="GET" action="" class="flex flex-wrap items-end gap-4">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                <select name="categoryId" id="category" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 min-w-[180px]">
                    <option value="">Tất cả</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ request('categoryId') == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end h-full gap-2">
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow min-w-[90px] justify-center">
                    Lọc
                </button>
                <a href="{{ route('admin.products.newProduct') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Thêm sản phẩm mới
                </a>
            </div>
        </form>
    </div>



    <!-- Bảng danh sách sản phẩm -->
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @php
                        $sort = request('sort', '');
                        $direction = request('direction', 'asc');
                        function sortUrl($column) {
                            $currentSort = request('sort', '');
                            $currentDirection = request('direction', 'asc');
                            $newDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
                            return request()->fullUrlWithQuery(['sort' => $column, 'direction' => $newDirection]);
                        }
                        function sortIcon($column) {
                            $currentSort = request('sort', '');
                            $currentDirection = request('direction', 'asc');
                            if ($currentSort === $column) {
                                return $currentDirection === 'asc' ? '▲' : '▼';
                            }
                            return '';
                        }
                    @endphp
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrl('product_id') }}" class="flex items-center gap-1">
                            ID <span class="text-xs">{{ sortIcon('product_id') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrl('product_name') }}" class="flex items-center gap-1">
                            Tên sản phẩm <span class="text-xs">{{ sortIcon('product_name') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrl('category') }}" class="flex items-center gap-1">
                            Danh mục <span class="text-xs">{{ sortIcon('category') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrl('price') }}" class="flex items-center gap-1">
                            Giá <span class="text-xs">{{ sortIcon('price') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrl('is_active') }}" class="flex items-center gap-1">
                            Trạng thái <span class="text-xs">{{ sortIcon('is_active') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrl('updated_at') }}" class="flex items-center gap-1">
                            Ngày cập nhật <span class="text-xs">{{ sortIcon('updated_at') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr>
                        <td class="px-4 py-2">{{ $product->product_id }}</td>
                        <td class="px-4 py-2 font-semibold">
                            <a href="{{ route('admin.products.variants', ['id' => $product->product_id]) }}" class="text-blue-700 hover:underline">
                                {{ $product->product_name }}
                            </a>
                        </td>
                        <td class="px-4 py-2">{{ $product->category->category_name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @php
                                if($product->variants && $product->variants->count() > 0) {
                                    $minPrice = $product->variants->min('price');
                                    $maxPrice = $product->variants->max('price');
                                } else {
                                    $minPrice = $product->price;
                                    $maxPrice = $product->price;
                                }
                            @endphp
                            @if($minPrice == $maxPrice)
                                {{ number_format($minPrice, 0, ',', '.') }} VNĐ
                            @else
                                {{ number_format($minPrice, 0, ',', '.') }} - {{ number_format($maxPrice, 0, ',', '.') }} VNĐ
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($product->is_active)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Hiển thị</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-600">Ẩn</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.products.updateProduct', ['id' => $product->product_id]) }}" class="text-blue-600 hover:underline mr-2">Sửa</a>
                            <a href="#" class="text-red-600 hover:underline">Xóa</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">Không có sản phẩm nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="mt-6">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
