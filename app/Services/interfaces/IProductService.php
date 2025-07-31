<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface IProductService
{
    public function showAll();
    public function showProductByCategoryId($id);
    public function getProductWithVariant();
    public function getProductWithVariantById($product_id);
    public function getProductWithVariantByCategoryId($id);
    public function getProductInAmount($categoryId = null, $minPrice, $maxPrice);
    public function getProductInStock($categoryId = null);
    public function sortProductNewest($categoryId = null);
    public function sortProductOldest($categoryId = null);

    public function filterProducts($product_name = null, $categoryId = null, $minPrice = null, $maxPrice = null, $inStock = null, $order = null);
    public function filterProductsBySlug($categorySlug = null, $minPrice = null, $maxPrice = null, $inStock = null, $order = null);
    public function adminFilterProducts($categoryId = null, $inStock = null, $product_name =  null, $sort = null, $direction = null);
    public function getProductDetail($product_id);

    public function newProduct(Request $request);
    public function updateProduct(Request $request);
    public function deleteProduct($product_id);

    // search sản phẩm
    public function searchProducts($product_name);
}
