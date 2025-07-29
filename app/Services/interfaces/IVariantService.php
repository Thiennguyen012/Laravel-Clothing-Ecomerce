<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface IVariantService
{
    public function getVariantByProductId($id);
    public function getVariantById($variant_id);
    public function getListVariant();
    public function variantFilter($product_id = null, $sort = null, $direction = null);
    public function newVariant(Request $request);
    public function updateVariant(Request $request);
    public function deleteVariant($variant_id);
}
