<?php

namespace App\Repository;

use App\Models\Variant;
use App\Repository\Interfaces\IVariantRepository;

class VariantRepository extends BaseRepository implements IVariantRepository
{
    public function __construct(Variant $variant)
    {
        parent::__construct($variant);
    }
    public function getVariantByProductId($id)
    {
        return $this->find(['product_id' => $id]);
    }
    public function getVariantById($variant_id)
    {
        return $this->model->with('product')->where('id', $variant_id)->first();
    }
    public function decreaseStock($variant_id, $quantity)
    {
        $variant = $this->model->where('id', $variant_id)->first();
        if (!$variant) {
            return null;
        }
        $variant->quantity -= $quantity;
        $variant->save();
        return true;
    }
    public function increaseStock($variant_id, $quantity)
    {
        $variant = $this->model->where('id', $variant_id)->first();
        if (!$variant) {
            return null;
        }
        $variant->quantity += $quantity;
        $variant->save();
        return true;
    }
    public function getListVariant()
    {
        $variants = $this->model->get();
        return $variants;
    }
    public function variantFilter($product_id = null, $sort = null, $direction = null)
    {
        $query = $this->model->with(['product']);
        if ($product_id) {
            $query = $query->where('product_id', $product_id);
        }
        if ($sort) {
            $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';
            switch ($sort) {
                case 'id':
                case 'price':
                case 'quantity':
                case 'sku':
                case 'size':
                case 'color':
                case 'is_active':
                case 'updated_at':
                    $query = $query->orderBy($sort, $direction);
                    break;
                case 'category':
                    $query = $query->join('products', 'variants.product_id', '=', 'products.product_id')
                        ->join('categories', 'products.category_id', '=', 'categories.category_id')
                        ->orderBy('categories.category_name', $direction)
                        ->select('variants.*');
                    break;
            }
        }
        return $query->paginate(12);
    }
    public function newVariant($product_id, $sku, $color, $size, $price, $compare_at_price, $quantity, $is_active, $images, $description)
    {
        return $this->model->create([
            'product_id' => $product_id,
            'sku' => $sku,
            'color' => $color,
            'size' => $size,
            'price' => $price,
            'compare_at_price' => $compare_at_price,
            'quantity' => $quantity,
            'is_active' => $is_active,
            'images' => $images,
            'description' => $description
        ]);
    }
    public function updateVariant($variant_id, $product_id, $sku, $color, $size, $price, $compare_at_price, $quantity, $is_active, $images, $description)
    {
        $this->model->where('id', $variant_id)->update([
            'product_id' => $product_id,
            'sku' => $sku,
            'color' => $color,
            'size' => $size,
            'price' => $price,
            'compare_at_price' => $compare_at_price,
            'quantity' => $quantity,
            'is_active' => $is_active,
            'images' => $images,
            'description' => $description
        ]);
    }
    public function deleteVariant($variant_id)
    {
        return $this->model->where('id', $variant_id)->delete();
    }
}
