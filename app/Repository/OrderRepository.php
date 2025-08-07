<?php

namespace App\Repository;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repository\Interfaces\IOrderRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderRepository extends BaseRepository implements IOrderRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Order $order)
    {
        parent::__construct($order);
    }
    public function newOrder(array $data = [])
    {
        return $this->model->create($data);
    }
    public function findOrder($user_id = null, $session_id = null)
    {
        if ($user_id && $session_id == null) {
            return null;
        }
        $result = $this->model->with('items')->where('user_id', $user_id)->paginate(12);
        return $result;
    }
    public function findOrderbyId($order_id)
    {
        $result = $this->model->with('items')->where('order_id', $order_id)->first();
        return $result;
    }

    public function findOrderByCustomerName($customer_name)
    {
        $result = $this->model->find(['customer_name', 'like', "%$customer_name%"]);
        return $result;
    }
    public function listOrder()
    {
        $orders = $this->model->with('items')->paginate(12);
        return $orders;
    }
    public function orderFilter(
        $order_id = null,
        $user_id = null,
        $session_id = null,
        $customer_name = null,
        $customer_email = null,
        $customer_phone = null,
        $shipping_address = null,
        $status = null,
        $sort = null,
        $direction = null
    ) {
        $query = $this->model->with('items');
        if ($order_id) {
            $query = $query->where('id', $order_id);
        }
        if ($customer_name) {
            $query = $query->where('customer_name', 'like', "%$customer_name%");
        }
        if ($customer_email) {
            $query = $query->where('customer_email', 'like', "%$customer_email%");
        }
        if ($customer_phone) {
            $query = $query->where('customer_phone', 'like', "%$customer_phone%");
        }
        if ($shipping_address) {
            $query = $query->where('shipping_address', 'like', "%$shipping_address%");
        }
        if ($status) {
            $query = $query->where('status', $status);
        }
        if ($sort) {
            $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';
            switch ($sort) {
                case 'id':
                case 'customer_name':
                case 'customer_email':
                case 'shipping_address':
                case 'total':
                case 'status':
                case 'updated_at':
                    $query = $query->orderBy($sort, $direction);
                    break;
                default:
                    $query = $query->orderBy('id', $direction);
            }
        } else {
            $query = $query->orderBy('id', 'desc');
        }
        return $query->paginate(12);
    }
    public function getOrderWithItemsById($order_id)
    {
        $result = $this->model->with('items')->where('id', $order_id)->first();
        return $result;
    }
    public function updateOrderStatus($order_id, $status = null)
    {
        // Lấy thông tin đơn hàng trước khi update (load nested relationship)
        $order = $this->model->with('items.variant')->find($order_id);

        if (!$order) {
            return false;
        }

        // Update status
        $this->model->where('id', $order_id)->update([
            'status' => $status,
        ]);

        // Nếu status = cancelled, hoàn lại số lượng cho các variant
        if ($status == 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->variant) {
                    // Cộng lại số lượng đã trừ vào variant (sử dụng stock_quantity)
                    $item->variant->increment('quantity', $item->quantity);
                }
            }
        }

        return true;
    }
    public function countOrder()
    {
        return $this->model->count();
    }
    public function totalRevenue()
    {
        return $this->model->where('status', 'completed')->sum('total');
    }
    public function getStatistics($period, $startDate, $endDate)
    {
        // Lấy tất cả đơn hàng để có dữ liệu hiển thị, doanh thu chỉ tính từ 'completed'
        $query = $this->model->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        switch ($period) {
            case 'day':
                return $query->select(
                    DB::raw('DATE(created_at) as period'),
                    DB::raw('COUNT(*) as orders'),
                    DB::raw('SUM(CASE WHEN status = "completed" THEN total ELSE 0 END) as revenue')
                )
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->orderBy('period')
                    ->get()
                    ->map(function ($item) {
                        $item->period = Carbon::parse($item->period)->format('d/m/Y');
                        return $item;
                    });

            case 'month':
                return $query->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as orders'),
                    DB::raw('SUM(CASE WHEN status = "completed" THEN total ELSE 0 END) as revenue')
                )
                    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get()
                    ->map(function ($item) {
                        $item->period = "Tháng {$item->month}/{$item->year}";
                        return $item;
                    });

            case 'quarter':
                return $query->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('QUARTER(created_at) as quarter'),
                    DB::raw('COUNT(*) as orders'),
                    DB::raw('SUM(CASE WHEN status = "completed" THEN total ELSE 0 END) as revenue')
                )
                    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('QUARTER(created_at)'))
                    ->orderBy('year')
                    ->orderBy('quarter')
                    ->get()
                    ->map(function ($item) {
                        $item->period = "Quý {$item->quarter}/{$item->year}";
                        return $item;
                    });

            case 'year':
                return $query->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('COUNT(*) as orders'),
                    DB::raw('SUM(CASE WHEN status = "completed" THEN total ELSE 0 END) as revenue')
                )
                    ->groupBy(DB::raw('YEAR(created_at)'))
                    ->orderBy('year')
                    ->get()
                    ->map(function ($item) {
                        $item->period = "Năm {$item->year}";
                        return $item;
                    });

            default:
                return collect();
        }
    }

    public function getTotalProducts()
    {
        return Product::count();
    }

    public function getTotalUsers()
    {
        return User::count();
    }

    public function getDashboardStatistics($period, $startDate, $endDate)
    {
        return [
            'totalOrders' => $this->countOrder(),
            'totalRevenue' => $this->totalRevenue(),
            'totalProducts' => $this->getTotalProducts(),
            'totalUsers' => $this->getTotalUsers(),
            'statistics' => $this->getStatistics($period, $startDate, $endDate)
        ];
    }
}
