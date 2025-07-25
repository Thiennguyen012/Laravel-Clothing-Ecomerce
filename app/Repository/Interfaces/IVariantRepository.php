<?php

namespace App\Repository\Interfaces;

interface IVariantRepository extends IBaseRepository
{
    //
    public function getVariantByProductId($id);
    public function decreaseStock($variant_id, $quantity);
    public function increaseStock($variant_id, $quantity);
}
