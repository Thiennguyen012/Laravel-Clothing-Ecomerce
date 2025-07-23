<?php

namespace App\Services;

use App\Repository\Interfaces\IVariantRepository;
use App\Repository\ProductRepository;
use App\Services\Interfaces\IVariantService;

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
}
