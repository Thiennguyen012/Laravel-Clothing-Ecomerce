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
    public function findOrderByCustomerName(Request $request)
    {
        $orders = $this->orderService->findOrderByCustomerName($request);
        return 1;
    }
}
