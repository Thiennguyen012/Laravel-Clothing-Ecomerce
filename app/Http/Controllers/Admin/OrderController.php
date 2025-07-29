<?php

namespace App\Http\Controllers\Admin;

use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\IOrderService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    protected $cartService;
    protected $orderService;
    public function __construct(ICartService $cartService, IOrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }
    public function showAll(Request $request)
    {
        $orders = $this->orderService->orderFilter($request);
        // dd($orders);
        return view('Admin.adminOrders', compact('orders'));
    }
    public function getOrderDetail($order_id)
    {
        $orderDetail = $this->orderService->getOrderWithItemsById($order_id);
        return view('Admin.adminOrderDetail', compact('orderDetail'));
    }
    public function updateOrderStatus(Request $request)
    {
        $this->orderService->updateOrderStatus($request);
        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}
