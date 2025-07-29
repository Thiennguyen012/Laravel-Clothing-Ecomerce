<?php

namespace App\Services\interfaces;

use Illuminate\Http\Request;

interface IOrderService
{
    public function checkout($user_id = null, $session_id = null, $customer_name, $customer_email, $customer_phone, $shipping_address, $note = null);
    public function orderFilter(Request $request);
    public function findOrderByCustomerName(Request $request);
    public function getOrderWithItemsById($order_id);
    public function updateOrderStatus(Request $request);
}
