<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IOrderService;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    protected $orderService;
    public function __construct(IOrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function index(Request $request)
    {
        // Lấy tất cả dữ liệu dashboard từ service
        $dashboardData = $this->orderService->getDashboardData($request);

        // Trả về view với dữ liệu
        return view('admin.dashboard', $dashboardData);
    }
}
