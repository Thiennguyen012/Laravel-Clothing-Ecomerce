<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\IProductService;
use App\Services\Interfaces\ICategoryService;
use App\Services\Interfaces\IVariantService;


class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $variantService;

    public function __construct(IProductService $productService, ICategoryService $categoryService, IVariantService $variantService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->variantService = $variantService;
    }
    public function newProduct(Request $request)
    {
        $this->productService->newProduct($request);
        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm mới thành công !'
        ]);
    }
}
