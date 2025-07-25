<?php

namespace App\Repository;

use App\Models\Variant;
use App\Repository\Interfaces\IVariantRepository;

class VariantRepository extends BaseRepository implements IVariantRepository
{
    public function __construct(Variant $variant)
    {
        parent::__construct($variant);
    }
    public function getVariantByProductId($id)
    {
        return $this->find(['product_id' => $id]);
    }
    public function decreaseStock($variant_id, $quantity)
    {
        $variant = $this->model->where('id', $variant_id)->first();
        if (!$variant) {
            return null;
        }
        $variant->quantity -= $quantity;
        $variant->save();
        return true;
    }
    public function increaseStock($variant_id, $quantity)
    {
        $variant = $this->model->where('id', $variant_id)->first();
        if (!$variant) {
            return null;
        }
        $variant->quantity += $quantity;
        $variant->save();
        return true;
    }
}
