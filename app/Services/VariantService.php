<?php

namespace App\Services;

use App\Repository\Interfaces\IVariantRepository;
use App\Repository\ProductRepository;
use App\Services\Interfaces\IVariantService;
use Illuminate\Http\Request;

class VariantService implements IVariantService
{
    protected $variantRepository;
    protected $productRepository;
    public function __construct(IVariantRepository $variantRepository, ProductRepository $productRepository)
    {
        $this->variantRepository = $variantRepository;
        $this->productRepository = $productRepository;
    }
    public function getVariantByProductId($id)
    {
        $variant = $this->variantRepository->getVariantByProductId($id);
        return $variant;
    }
    public function getVariantById($variant_id)
    {
        return $this->variantRepository->getVariantById($variant_id);
    }
    public function getListVariant()
    {
        return $this->variantRepository->getListVariant();
    }
    public function variantFilter($product_id = null, $sort = null, $direction = null)
    {
        $result =  $this->variantRepository->variantFilter($product_id, $sort, $direction);
        return $result;
    }
    public function updateVariant(Request $request)
    {
        $variant_id = $request->input('variant_id');
        $product_id = $request->input('product_id');
        $sku = $request->input('sku');
        $color = $request->input('color');
        $size = $request->input('size');
        $price = $request->input('price');
        $compare_at_price = $request->input('compare_at_price');
        $quantity = $request->input('quantity');
        $is_active = $request->input('is_active');
        $images = $request->input('images');
        $description = $request->input('description');
        return $this->variantRepository->updateVariant($variant_id, $product_id, $sku, $color, $size, $price, $compare_at_price, $quantity, $is_active, $images, $description);
    }
}
