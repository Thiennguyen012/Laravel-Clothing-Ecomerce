<?php

namespace App\Repository;

use App\Models\Product;
use App\Repository\Interfaces\IProductRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository implements IProductRepository
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }
    public function getProductWithVariant()
    {
        return $this->model->with(['variants', 'category'])->paginate(12);
    }
    public function getProductWithVariantById($id)
    {
        $product = $this->model->with('category')->find($id);
        if ($product) {
            $product->variants_paginated = $product->variants()->paginate(10);
        }
        return $product;
    }
    public function getProductWithVariantByCategoryId($id)
    {
        return $this->model->where('category_id', $id)->with(['variants', 'category'])->paginate(12);
    }
    public function getProductInAmount($categoryId = null, $minPrice, $maxPrice)
    {
        $query = $this->model;
        if ($categoryId != null) {
            $query = $query->where('category_id', $categoryId);
        }
        // Lấy products có ít nhất 1 variant trong khoảng giá
        $result = $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
            $q->whereBetween('price', [$minPrice, $maxPrice]);
        })->paginate(12);
        return $result;
    }
    public function getProductInStock($categoryId = null)
    {
        $query = $this->model;
        if ($categoryId) {
            $query = $query->where('category_id', $categoryId);
        }
        $result = $query->whereHas('variants', function ($q) {
            $q->where('price', '>', 0);
        })->paginate(12);
        return $result;
    }
    public function sortProduct($categoryId = null, array $conditions = [])
    {
        $query = $this->model;
        if ($categoryId) {
            $query = $query->where('category_id', $categoryId);
        }
        $result = $query->whereHas('variants', function ($q) use ($conditions) {
            $q->orderBy($conditions);
        });
        return $result;
    }
    public function filterProducts($categoryId = null, $minPrice = null, $maxPrice = null, $inStock = null, $order = null)
    {
        $query = $this->model->with(['variants', 'category']);

        if ($categoryId) {
            $query = $query->where('category_id', $categoryId);
        }

        if ($minPrice && $maxPrice) {
            $query = $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('price', [$minPrice, $maxPrice]);
            });
        }

        if ($inStock) {
            $query = $query->whereHas('variants', function ($q) {
                $q->where('quantity', '>', 0);
            });
        }
        if ($order) {
            switch ($order) {
                case 'newest':
                    $query = $query->orderBy('updated_at', 'desc');
                    break;
                case 'oldest':
                    $query = $query->orderBy('updated_at', 'asc');
                    break;
                case 'priceDown':
                    $query = $query->orderBy(
                        DB::raw('(SELECT MAX(price) FROM variants WHERE variants.product_id = products.product_id)'),
                        'desc'
                    );
                    break;
                case 'priceUp':
                    $query = $query->orderBy(
                        DB::raw('(SELECT MIN(price) FROM variants WHERE variants.product_id = products.product_id)'),
                        'asc'
                    );
                    break;
                case 'name':
                    $query = $query->orderBy('product_name', 'asc');
                    break;
            }
        }

        return $query->paginate(12);
    }
    public function adminFilterProducts($categoryId = null, $inStock = null, $sort = null, $direction = null)
    {
        $query = $this->model->with(['variants', 'category']);

        if ($categoryId) {
            $query = $query->where('category_id', $categoryId);
        }

        if ($inStock) {
            $query = $query->whereHas('variants', function ($q) {
                $q->where('quantity', '>', 0);
            });
        }

        // Sắp xếp
        if ($sort) {
            $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';
            switch ($sort) {
                case 'product_id':
                case 'product_name':
                case 'is_active':
                case 'updated_at':
                    $query = $query->orderBy($sort, $direction);
                    break;
                case 'category':
                    $query = $query->join('categories', 'products.category_id', '=', 'categories.category_id')
                        ->orderBy('categories.category_name', $direction)
                        ->select('products.*');
                    break;
                case 'price':
                    // Sắp xếp theo giá nhỏ nhất của variant
                    $query = $query->orderBy(
                        DB::raw('(SELECT MIN(price) FROM variants WHERE variants.product_id = products.product_id)'),
                        $direction
                    );
                    break;
            }
        }

        return $query->paginate(12);
    }
    public function newProduct($product_name, $description, $is_active, $category_id)
    {
        return $this->model->create([
            'product_name' => $product_name,
            'description' => $description,
            'is_active' => $is_active,
            'category_id' => $category_id,
        ]);
    }
}
