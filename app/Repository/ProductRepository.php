<?php

namespace App\Repository;

use App\Models\Product;
use App\Repository\Interfaces\IProductRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->model->with(['variants', 'category'])->find($id);
    }
    public function getProductWithVariantByCategoryId($id)
    {
        return $this->model->where('category_id', $id)->with(['variants', 'category'])->get();
    }
    public function getProductInAmount($categoryId = null, $minPrice, $maxPrice)
    {
        // $query = $this->model->with([
        //     'variants' => function ($q) use ($minPrice, $maxPrice) {
        //         // Chỉ load variants trong khoảng giá được lọc
        //         $q->whereBetween('price', [$minPrice, $maxPrice]);
        //     },
        //     'category'
        // ]);
        $query = $this->model;
        if ($categoryId != null) {
            $query = $query->where('category_id', $categoryId);
        }

        // Lấy products có ít nhất 1 variant trong khoảng giá
        $result = $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
            $q->whereBetween('price', [$minPrice, $maxPrice]);
        })->get();

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
        })->get();
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
}
