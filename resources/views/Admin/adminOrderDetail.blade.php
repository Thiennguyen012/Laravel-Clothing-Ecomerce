@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-4">Chi tiết đơn hàng #{{ $orderDetail->id }}</h1>
        <a href="{{ route('admin.orders.view') }}" class="inline-block mb-4 px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">← Quay lại danh sách đơn hàng</a>
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-2">Thông tin chi tiết đơn hàng</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong>ID:</strong> {{ $orderDetail->id }}</div>
                @if($orderDetail->user_id)
                    <div><strong>User ID:</strong> {{ $orderDetail->user_id }}</div>
                @elseif($orderDetail->session_id)
                    <div><strong>Session ID:</strong> {{ $orderDetail->session_id }}</div>
                @else
                    <div><strong>User/Session ID:</strong> -</div>
                @endif
                <div><strong>Tên khách hàng:</strong> {{ $orderDetail->customer_name ?? $orderDetail->user->name ?? '-' }}</div>
                <div><strong>Email:</strong> {{ $orderDetail->customer_email ?? $orderDetail->user->email ?? '-' }}</div>
                <div><strong>Số điện thoại:</strong> {{ $orderDetail->customer_phone ?? '-' }}</div>
                <div><strong>Địa chỉ:</strong> {{ $orderDetail->shipping_address ?? '-' }}</div>
                <div><strong>Ghi chú:</strong> {{ $orderDetail->notes ?? '-' }}</div>
                <div><strong>Trạng thái:</strong> <span class="font-semibold">{{ $orderDetail->status }}</span></div>
                <div><strong>Phương thức thanh toán:</strong> {{ $orderDetail->payment_method ?? '-' }}</div>
                <div><strong>Trạng thái thanh toán:</strong> {{ $orderDetail->payment_status ?? '-' }}</div>
                <div><strong>Tiền hàng (subtotal):</strong> {{ number_format($orderDetail->subtotal, 0, ',', '.') }} VNĐ</div>
                <div><strong>Phí vận chuyển:</strong> {{ number_format($orderDetail->shipping_fee, 0, ',', '.') }} VNĐ</div>
                <div><strong>Tổng tiền:</strong> {{ number_format($orderDetail->total, 0, ',', '.') }} VNĐ</div>
                <div><strong>Ngày tạo:</strong> {{ $orderDetail->created_at ? $orderDetail->created_at->format('d/m/Y H:i') : '-' }}</div>
                <div><strong>Ngày cập nhật:</strong> {{ $orderDetail->updated_at ? $orderDetail->updated_at->format('d/m/Y H:i') : '-' }}</div>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="text-md font-semibold mb-2 mt-2">Danh sách sản phẩm</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sản phẩm</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Màu sắc</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Size</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Giá</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orderDetail->items as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->product_name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $item->variant_sku ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $item->color ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $item->size ?? '-' }}</td>
                                <td class="px-4 py-2">{{ number_format($item->unit_price, 0, ',', '.') }} VNĐ</td>
                                <td class="px-4 py-2">{{ $item->quantity }}</td>
                                <td class="px-4 py-2">{{ number_format($item->total_price, 0, ',', '.') }} VNĐ</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">Không có sản phẩm nào trong đơn hàng này.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
