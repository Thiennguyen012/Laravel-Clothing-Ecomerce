<?php

namespace App\Services;

use App\Repository\Interfaces\IProductRepository;
use App\Repository\ProductRepository;
use App\Services\Interfaces\IProductService;
use Illuminate\Http\Request;

class ProductService implements IProductService
{
    protected $productRepository;
    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    // chỉ lấy ra sản phẩm , không lấy được variant
    public function showAll()
    {
        $condititon = [];
        $data = $this->productRepository->find($condititon);
        return $data;
    }
    public function showProductByCategoryId($id)
    {
        $result = $this->productRepository->find(['category_id' => $id]);
        return $result;
    }
    // hàm lấy ra tất cả sản phẩm kèm variant
    public function getProductWithVariant()
    {
        $result = $this->productRepository->getProductWithVariant();
        return $result;
    }
    public function getProductWithVariantById($product_id)
    {
        $result = $this->productRepository->getProductWithVariantById($product_id);
        return $result;
    }
    public function getProductWithVariantByCategoryId($id)
    {
        $result = $this->productRepository->getProductWithVariantByCategoryId($id);
        return $result;
    }
    public function getProductInAmount($categoryId = null, $minPrice, $maxPrice)
    {
        $result = $this->productRepository->getProductInAmount($categoryId, $minPrice, $maxPrice);
        return $result;
    }
    public function getProductInStock($categoryId = null)
    {
        $result = $this->productRepository->getProductInStock($categoryId);
        return $result;
    }
    public function sortProductNewest($categoryId = null)
    {
        $conditions = ['update_at' => 'desc'];
        $result = $this->productRepository->sortProduct($categoryId, $conditions);
        return $result;
    }
    public function sortProductOldest($categoryId = null)
    {
        $conditions = ['update_at' => 'asc'];
        $result = $this->productRepository->sortProduct($categoryId, $conditions);
        return $result;
    }
    // filter chính của trang products
    public function filterProducts($product_name = null, $categoryId = null, $minPrice = null, $maxPrice = null, $inStock = null, $order = null)
    {
        $result = $this->productRepository->filterProducts($product_name, $categoryId, $minPrice, $maxPrice, $inStock, $order);
        return $result;
    }

    public function filterProductsBySlug($categorySlug = null, $minPrice = null, $maxPrice = null, $inStock = null, $order = null)
    {
        $result = $this->productRepository->filterProductsBySlug($categorySlug, $minPrice, $maxPrice, $inStock, $order);
        return $result;
    }

    public function adminFilterProducts($categoryId = null, $inStock = null, $product_name = null, $sort = null, $direction = null)
    {
        $result = $this->productRepository->adminFilterProducts($categoryId, $inStock, $product_name, $sort, $direction);
        return $result;
    }
    public function getProductDetail($product_id)
    {
        $result = $this->productRepository->getProductWithVariantById($product_id);
        return $result;
    }
    public function newProduct(Request $request)
    {
        $product_name = $request->input('product_name');
        $description = $request->input('description');
        $is_active = $request->input('is_active');
        $category_id = $request->input('category_id');
        $this->productRepository->newProduct($product_name, $description, $is_active, $category_id);
    }
    public function updateProduct(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_name = $request->input('product_name');
        $description = $request->input('description');
        $is_active = $request->input('is_active');
        $category_id = $request->input('category_id');
        return $this->productRepository->updateProduct($product_id, $product_name, $description, $is_active, $category_id);
    }
    public function deleteProduct($product_id)
    {
        return $this->productRepository->deleteProduct($product_id);
    }
    public function searchProducts($product_name)
    {
        $products = $this->productRepository->searchProducts($product_name);
        return $products;
    }
}
