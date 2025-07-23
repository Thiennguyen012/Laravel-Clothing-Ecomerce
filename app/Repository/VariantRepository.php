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
}
