<?php

namespace App\Repository\Interfaces;

interface IProductRepository extends IBaseRepository
{
    //
    public function getProductWithVariant();
    public function getProductWithVariantById($id);
    public function getProductWithVariantByCategoryId($id);
    public function getProductInAmount($categoryId = null, $minPrice, $maxPrice);
    public function getProductInStock($categoryId = null);
    public function sortProduct($categoryId = null, array $conditions = []);

    // hàm filter
    public function filterProducts($categoryId, $minPrice, $maxPrice, $inStock, $order);
    public function decreaseStock($variant_id, $quantity);
    public function increaseStock($variant_id, $quantity);
}
