<?php

namespace App\Repository\Interfaces;

interface IOrderRepository extends IBaseRepository
{
    public function newOrder(array $data = []);
    public function findOrder($user_id = null, $session_id = null);
    public function findOrderbyId($order_id);
}
