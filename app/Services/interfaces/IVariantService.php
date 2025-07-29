<?php

namespace App\Services\Interfaces;

interface IVariantService
{
    public function getVariantByProductId($id);
    public function getListVariant();
    public function variantFilter($product_id = null, $sort = null, $direction = null);
}
