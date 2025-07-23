<?php

namespace App\Services\Interfaces;

interface IProductService
{
    public function showAll();
    public function showProductByCategoryId($id);
    public function getProductWithVariant();
    public function getProductWithVariantByCategoryId($id);
    public function getProductInAmount($categoryId = null, $minPrice, $maxPrice);
    public function getProductInStock($categoryId = null);
    public function sortProductNewest($categoryId = null);
    public function sortProductOldest($categoryId = null);
}
