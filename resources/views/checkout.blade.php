@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    @if(isset($order))
        <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
            <svg class="mx-auto h-16 w-16 text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <h2 class="text-2xl font-bold text-green-600 mb-2">Đặt hàng thành công!</h2>
            <p class="text-gray-700 mb-4">Cảm ơn bạn đã mua hàng. Đơn hàng của bạn đã được ghi nhận.</p>
            <div class="bg-gray-50 rounded-lg p-4 text-left mb-4">
                <div class="mb-2"><span class="font-semibold">Mã đơn hàng:</span> {{ $order->order_number ?? $order->id }}</div>
                <div class="mb-2"><span class="font-semibold">Tên khách hàng:</span> {{ $order->customer_name }}</div>
                <div class="mb-2"><span class="font-semibold">Số điện thoại:</span> {{ $order->customer_phone }}</div>
                <div class="mb-2"><span class="font-semibold">Địa chỉ giao hàng:</span> {{ $order->shipping_address ?? $order->customer_address }}</div>
                <div class="mb-2"><span class="font-semibold">Tổng tiền:</span> <span class="text-blue-600 font-bold">{{ number_format($order->total ?? 0, 0, ',', '.') }}đ</span></div>
            </div>
            <a href="{{ route('products') }}" class="inline-block mt-4 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 transition">Tiếp tục mua sắm</a>
        </div>
    @elseif(isset($cart))
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-blue-700 mb-6">Xác nhận đơn hàng</h2>
            @if($cart && count($cart) > 0)
                <form method="POST" action="{{ route('checkout') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên khách hàng</label>
                        <input type="text" name="customer_name" class="w-full border rounded-md px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="customer_email" class="w-full border rounded-md px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                        <input type="text" name="customer_phone" class="w-full border rounded-md px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ giao hàng</label>
                        <input type="text" name="shipping_address" class="w-full border rounded-md px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú (tuỳ chọn)</label>
                        <textarea name="note" class="w-full border rounded-md px-3 py-2"></textarea>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-2">Sản phẩm trong giỏ hàng</h3>
                        <ul class="divide-y divide-gray-200">
                            @foreach($cart as $item)
                                <li class="py-2 flex items-center justify-between">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $item->product_name ?? $item->variant->product->product_name ?? 'Sản phẩm' }}</div>
                                        <div class="text-xs text-gray-500">Size: {{ $item->size ?? $item->variant->size ?? '-' }} | Màu: {{ $item->color ?? $item->variant->color ?? '-' }}</div>
                                    </div>
                                    <div class="text-blue-600 font-bold">x{{ $item->quantity }}</div>
                                    <div class="text-gray-700">{{ number_format($item->price ?? $item->unit_price ?? 0, 0, ',', '.') }}đ</div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl shadow hover:bg-blue-700 transition">Đặt hàng</button>
                </form>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6M7 13h10M9 19a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Giỏ hàng trống</h3>
                    <p class="mt-1 text-gray-500">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                    <a href="{{ route('products') }}" class="inline-block mt-4 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 transition">Tiếp tục mua sắm</a>
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-lg font-medium text-gray-900">Không có dữ liệu đơn hàng hoặc giỏ hàng.</h3>
            <a href="{{ route('products') }}" class="inline-block mt-4 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 transition">Quay lại mua sắm</a>
        </div>
    @endif
</div>
@endsection
