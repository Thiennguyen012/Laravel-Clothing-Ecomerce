<?php

namespace App\Repository;

use App\Models\Product;
use App\Repository\Interfaces\IProductRepository;

class ProductRepository extends BaseRepository implements IProductRepository
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }
    public function getProductWithVariant()
    {
        return $this->model->with(['variants', 'category'])->get();
    }
    public function getProductWithVariantById($id)
    {
        return $this->model->with(['variants', 'category'])->get()->find(['product_id' => $id]);
    }
    public function getProductWithVariantByCategoryId($id)
    {
        return $this->model->where('category_id', $id)->with('variants')->get();
    }
    public function getProductInAmount($categoryId = null, $minPrice, $maxPrice)
    {
        $product = $this->model->with(['variants', 'category']);
        if ($categoryId != null) {
            $product = $product->where('category_id', $categoryId);
        }
        // loc khoang gia
        $result = $product->whereBetween('price', [$minPrice, $maxPrice])->get();
        return $result;
    }
}
