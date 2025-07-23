<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

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
    public function filterProducts($categoryId = null, $minPrice = null, $maxPrice = null, $inStock = null, $order = null);
}
