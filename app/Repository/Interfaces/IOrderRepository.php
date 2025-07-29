<?php

namespace App\Repository\Interfaces;

interface IOrderRepository extends IBaseRepository
{
    public function newOrder(array $data = []);
    public function findOrder($user_id = null, $session_id = null);
    public function findOrderbyId($order_id);
    public function findOrderByCustomerName($customer_name);
    public function orderFilter(
        $order_id = null,
        $customer_name = null,
        $customer_email = null,
        $customer_phone = null,
        $shipping_address = null,
        $status = null,
        $sort = null,
        $direction = null,
    );
    public function getOrderWithItemsById($order_id);
    public function updateOrderStatus($order_id, $status = null);
}
