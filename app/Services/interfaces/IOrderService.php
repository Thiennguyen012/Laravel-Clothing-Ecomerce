<?php

namespace App\Services\interfaces;

interface IOrderService
{
    public function checkout($user_id = null, $session_id = null, $customer_name, $customer_email, $customer_phone, $shipping_address, $note = null);
}
