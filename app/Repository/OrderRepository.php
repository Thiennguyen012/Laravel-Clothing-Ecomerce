<?php

namespace App\Repository;

use App\Models\Order;
use App\Repository\Interfaces\IOrderRepository;

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
    public function updateOrderStatus($order_id, $status = null) {
        $this->model->where('id', $order_id)->update([
            'status' => $status,
        ]);
    }
}
