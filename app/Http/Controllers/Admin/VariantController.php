<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IProductService;
use App\Services\Interfaces\IVariantService;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    protected $variantService;
    protected $productService;
    public function __construct(IVariantService $variantService, IProductService $productService)
    {
        $this->variantService = $variantService;
        $this->productService = $productService;
    }

    public function showUpdateVariant($variant_id)
    {
        $variant = $this->variantService->getVariantById($variant_id);
        return view('Admin.adminUpdateVariant', compact('variant'));
    }

    public function updateVariant(Request $request)
    {
        $this->variantService->updateVariant($request);
        return redirect()->back()->with('success', 'Cập nhật variant thành công!');
    }
}
