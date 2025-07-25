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
        $result = $this->model->with('items')->where('user_id', $user_id)->get();
        return $result;
    }
    public function findOrderbyId($order_id)
    {
        $result = $this->model->with('items')->where('order_id', $order_id)->first();
        return $result;
    }
}
