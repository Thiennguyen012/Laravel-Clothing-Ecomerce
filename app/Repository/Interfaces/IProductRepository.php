<?php

namespace App\Repository\Interfaces;

interface IProductRepository extends IBaseRepository
{
    //
    public function getProductWithVariant();
    public function getProductWithVariantById($id);
    public function getProductWithVariantByCategoryId($id);
    public function getProductInAmount($categoryId = null, $minPrice, $maxPrice);
}
