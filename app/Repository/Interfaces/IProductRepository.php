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
    public function filterProductsBySlug($categorySlug = null, $minPrice = null, $maxPrice = null, $inStock = null, $order = null);
    public function adminFilterProducts($categoryId = null, $inStock = null, $product_name = null, $sort = null, $direction = null);
    // crud
    public function newProduct($product_name, $description, $is_active, $category_id);
    public function updateProduct($product_id, $product_name, $description, $is_active, $category_id);
    public function deleteProduct($product_id);
}
