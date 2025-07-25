<?php

namespace App\Repository;

use App\Models\OrderItem;
use App\Repository\Interfaces\IOrderItemRepository;

class OrderItemRepository extends BaseRepository implements IOrderItemRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(OrderItem $orderItem)
    {
        parent::__construct($orderItem);
    }
    public function newOrderItem(array $data = [])
    {
        return $this->model->create($data);
    }
}
