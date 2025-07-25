<?php

namespace App\Repository\Interfaces;

interface IOrderItemRepository extends IBaseRepository
{
    public function newOrderItem(array $data = []);
}
