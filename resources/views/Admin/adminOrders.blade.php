@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-4">Quản lý đơn hàng</h1>
        <form method="GET" action="" class="flex flex-nowrap items-end gap-4 overflow-x-auto">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                <select name="status" id="status" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 min-w-[150px] px-3 py-2 whitespace-nowrap">
                    <option value="">Tất cả</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đã gửi hàng</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Tên khách hàng</label>
                <input type="text" name="customer_name" id="customer_name" value="{{ request('customer_name') }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 min-w-[140px] px-3 py-2 whitespace-nowrap" placeholder="Tên khách hàng">
            </div>
            <div>
                <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="text" name="customer_email" id="customer_email" value="{{ request('customer_email') }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 min-w-[140px] px-3 py-2 whitespace-nowrap" placeholder="Email">
            </div>
            <div>
                <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                <input type="text" name="customer_phone" id="customer_phone" value="{{ request('customer_phone') }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 min-w-[120px] px-3 py-2 whitespace-nowrap" placeholder="Số điện thoại">
            </div>
            <div>
                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                <input type="text" name="shipping_address" id="shipping_address" value="{{ request('shipping_address') }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 min-w-[150px] px-3 py-2 whitespace-nowrap" placeholder="Địa chỉ">
            </div>
            <div class="flex items-end h-full gap-2">
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow min-w-[90px] justify-center">
                    Lọc
                </button>
                <a href="{{ route(request()->route()->getName()) }}" class="inline-flex items-center px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition shadow min-w-[90px] justify-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        @php
            $sort = request('sort', '');
            $direction = request('direction', 'asc');
            function sortUrlOrder($column) {
                $currentSort = request('sort', '');
                $currentDirection = request('direction', 'asc');
                $newDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
                return request()->fullUrlWithQuery(['sort' => $column, 'direction' => $newDirection]);
            }
            function sortIconOrder($column) {
                $currentSort = request('sort', '');
                $currentDirection = request('direction', 'asc');
                if ($currentSort === $column) {
                    return $currentDirection === 'asc' ? '▲' : '▼';
                }
                return '';
            }
        @endphp
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlOrder('id') }}" class="flex items-center gap-1">
                            Mã đơn <span class="text-xs">{{ sortIconOrder('id') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlOrder('customer_name') }}" class="flex items-center gap-1">
                            Khách hàng <span class="text-xs">{{ sortIconOrder('customer_name') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlOrder('customer_email') }}" class="flex items-center gap-1">
                            Email <span class="text-xs">{{ sortIconOrder('customer_email') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlOrder('customer_phone') }}" class="flex items-center gap-1">
                            Số điện thoại <span class="text-xs">{{ sortIconOrder('customer_phone') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlOrder('shipping_address') }}" class="flex items-center gap-1">
                            Địa chỉ <span class="text-xs">{{ sortIconOrder('shipping_address') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlOrder('total') }}" class="flex items-center gap-1">
                            Tổng tiền <span class="text-xs">{{ sortIconOrder('total') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlOrder('status') }}" class="flex items-center gap-1">
                            Trạng thái <span class="text-xs">{{ sortIconOrder('status') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlOrder('created_at') }}" class="flex items-center gap-1">
                            Ngày tạo <span class="text-xs">{{ sortIconOrder('created_at') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-4 py-2 font-semibold whitespace-nowrap">{{ $order->id }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $order->customer_name ?? $order->user->name ?? '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $order->customer_email ?? $order->user->email ?? '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $order->customer_phone ?? '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $order->shipping_address ?? '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.orders.updateStatus') }}">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <select name="status" class="border-gray-300 rounded px-2 py-1 text-base whitespace-nowrap" style="min-width:120px;" onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đã gửi hàng</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <a href="{{ route('admin.orders.detail', ['id' => $order->id]) }}" class="text-blue-600 hover:underline mr-2">Xem</a>
                            <a href="#" class="text-red-600 hover:underline">Xóa</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Không có đơn hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="mt-6">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
@endsection
