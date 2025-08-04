<?php

namespace App\Services;

use App\Repository\Interfaces\ICartRepository;
use App\Repository\Interfaces\IOrderItemRepository;
use App\Repository\Interfaces\IOrderRepository;
use App\Repository\Interfaces\IVariantRepository;
use App\Services\Interfaces\IOrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderService implements IOrderService
{
    protected $orderRepository;
    protected $orderItemRepository;
    protected $cartRepository;
    protected $variantRepository;
    public function __construct(IOrderRepository $orderRepository, IOrderItemRepository $orderItemRepository, ICartRepository $cartRepository, IVariantRepository $variantRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->cartRepository = $cartRepository;
        $this->variantRepository = $variantRepository;
    }
    public function checkout($user_id = null, $session_id = null, $customer_name, $customer_email, $customer_phone, $shipping_address, $note = null)
    {

        // Lấy ra giỏ hàng của người dùng hiện tại
        $cart = $this->cartRepository->getCartWithVariantAndProduct($user_id, $session_id);
        // dd($cart);

        // Tính tổng tiền hàng (subtotal)
        $subtotal = $cart->sum(function ($item) {
            return $item->variant->price * $item->quantity;
        });
        // dd($subtotal);
        // Phí vận chuyển (có thể thay đổi logic tính phí nếu cần)
        $shipping_fee = 0;
        // Tổng thanh toán
        $total = $subtotal + $shipping_fee;

        // Chuẩn bị dữ liệu order
        $orderData = [
            'user_id' => $user_id,
            'session_id' => $session_id,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'shipping_address' => $shipping_address,
            'subtotal' => $subtotal,
            'shipping_fee' => $shipping_fee,
            'total' => $total,
            'notes' => $note,
        ];

        // mapping cart với array cartItems, sau đó lưu cartItems vào bảng cart_items
        $cartItems = $cart->map(function ($item) {
            return [
                'variant_id'    => $item->variant_id,
                'product_name'  => $item->variant->product->product_name ?? null,
                'variant_sku'   => $item->variant->sku ?? null,
                'color'         => $item->variant->color ?? null,
                'size'          => $item->variant->size ?? null,
                'product_image' => $item->variant->images ?? null,
                'quantity'      => $item->quantity,
                'unit_price'    => $item->variant->price,
                'total_price'   => $item->variant->price * $item->quantity,
            ];
        })->toArray();
        // dd($cartItems);
        return DB::transaction(function () use ($orderData, $cartItems, $user_id, $session_id) {
            $order = $this->orderRepository->newOrder($orderData);
            foreach ($cartItems as $item) {
                $item['order_id'] = $order->id;
                $this->orderItemRepository->newOrderItem($item);
                // xử lý trừ kho
                $variant_id = $item['variant_id'];
                $quantity = $item['quantity'];
                $this->variantRepository->decreaseStock($variant_id, $quantity);
            }
            // Xử lý thêm: trừ kho, gửi mail, xóa cart...
            // xử lý xóa cart
            $this->cartRepository->deleteCart($user_id, $session_id);


            return $order;
        });
    }
    public function orderFilter(Request $request)
    {
        $order_id = $request->input('order_id');
        $user_id = $request->input('user_id');
        $session_id = $request->input('session_id');
        $customer_name = $request->input('customer_name');
        $customer_email = $request->input('customer_email');
        $customer_phone = $request->input('customer_phone');
        $shipping_address = $request->input('shipping_address');
        $status = $request->input('status');
        $sort = $request->input('sort');
        $direction = $request->input('direction');
        $result =  $this->orderRepository->orderFilter(
            $order_id,
            $user_id,
            $session_id,
            $customer_name,
            $customer_email,
            $customer_phone,
            $shipping_address,
            $status,
            $sort,
            $direction
        );
        return $result;
    }
    public function findOrderByCustomerName(Request $request)
    {
        $customer_name = $request->input('customer_name');
        return $this->orderRepository->findOrderByCustomerName($customer_name);
    }
    public function getOrderWithItemsById($order_id)
    {
        $result = $this->orderRepository->getOrderWithItemsById($order_id);
        return $result;
    }
    public function updateOrderStatus(Request $request)
    {
        $order_id = $request->input('order_id');
        $status = $request->input('status');
        return $this->orderRepository->updateOrderStatus($order_id, $status);
    }
    public function countOrder()
    {
        $result = $this->orderRepository->countOrder();
        return $result;
    }
    public function totalRevenue()
    {
        $result =  $this->orderRepository->totalRevenue();
        return $result;
    }
    public function getStatistics(Request $request)
    {
        $period = $request->get('period');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $result = $this->orderRepository->getStatistics($period, $start_date, $end_date);
        return $result;
    }

    public function getTotalProducts()
    {
        return $this->orderRepository->getTotalProducts();
    }

    public function getTotalUsers()
    {
        return $this->orderRepository->getTotalUsers();
    }

    public function getDashboardData(Request $request)
    {
        // Business Logic: Xử lý parameters và set default values
        $period = $request->get('period', 'day');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Business Logic: Set default dates based on period
        if (empty($startDate) || empty($endDate)) {
            [$startDate, $endDate] = $this->getDefaultDateRange($period);
        }

        // Business Logic: Cập nhật request với processed values
        $request->merge([
            'period' => $period,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        // Database Logic: Delegate to repository
        $dashboardStats = $this->orderRepository->getDashboardStatistics($period, $startDate, $endDate);

        // Business Logic: Format and prepare data for view
        return $this->formatDashboardData($dashboardStats, $period);
    }

    /**
     * Business Logic: Get default date range based on period
     */
    private function getDefaultDateRange($period)
    {
        switch ($period) {
            case 'day':
                return [
                    Carbon::now()->subDays(7)->format('Y-m-d'),
                    Carbon::now()->format('Y-m-d')
                ];
            case 'month':
                return [
                    Carbon::now()->subMonths(6)->startOfMonth()->format('Y-m-d'),
                    Carbon::now()->endOfMonth()->format('Y-m-d')
                ];
            case 'quarter':
                return [
                    Carbon::now()->subYears(2)->startOfQuarter()->format('Y-m-d'),
                    Carbon::now()->endOfQuarter()->format('Y-m-d')
                ];
            case 'year':
                return [
                    Carbon::now()->subYears(3)->startOfYear()->format('Y-m-d'),
                    Carbon::now()->endOfYear()->format('Y-m-d')
                ];
            default:
                return [
                    Carbon::now()->subMonths(3)->format('Y-m-d'),
                    Carbon::now()->format('Y-m-d')
                ];
        }
    }

    /**
     * Business Logic: Format dashboard data for view
     */
    private function formatDashboardData($dashboardStats, $period)
    {
        // Business Logic: Create period text mapping
        $periodText = [
            'day' => 'theo ngày',
            'month' => 'theo tháng',
            'quarter' => 'theo quý',
            'year' => 'theo năm'
        ][$period] ?? 'theo ngày';

        // Business Logic: Prepare chart data
        $chartData = [
            'labels' => $dashboardStats['statistics']->pluck('period')->toArray(),
            'revenue' => $dashboardStats['statistics']->pluck('revenue')->toArray(),
            'orders' => $dashboardStats['statistics']->pluck('orders')->toArray()
        ];

        return [
            'totalOrders' => $dashboardStats['totalOrders'],
            'totalRevenue' => $dashboardStats['totalRevenue'],
            'totalProducts' => $dashboardStats['totalProducts'],
            'totalUsers' => $dashboardStats['totalUsers'],
            'statistics' => $dashboardStats['statistics'],
            'chartData' => $chartData,
            'periodText' => $periodText
        ];
    }
}
