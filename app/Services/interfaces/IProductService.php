<?php

namespace App\Services\Interfaces;

interface IProductService
{
    public function showAll();
    public function showProductByCategoryId($id);
    public function getProductWithVariant();
    public function getProductWithVariantByCategoryId($id);
    public function getProductInAmount($categoryId = null, $minPrice, $maxPrice);
}
