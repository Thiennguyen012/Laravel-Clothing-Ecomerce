<?php

namespace App\Repository\Interfaces;

interface IVariantRepository extends IBaseRepository
{
    //
    public function getVariantByProductId($id);
    public function getVariantById($variant_id);
    public function decreaseStock($variant_id, $quantity);
    public function increaseStock($variant_id, $quantity);
    public function getListVariant();
    public function variantFilter($product_id = null, $sort = null, $direction = null);
    public function updateVariant($variant_id, $product_id, $sku, $color, $size, $price, $compare_at_price, $quantity, $is_active, $images, $description);
}
