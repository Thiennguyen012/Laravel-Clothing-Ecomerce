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

    public function index()
    {
        return view('Admin.adminProducts');
    }

    public function showAll(Request $request)
    {
        // lấy thông tin từ request
        $categoryId = $request->input('categoryId');
        $inStock = $request->input('inStock');
        $sort = $request->input('sort');
        $direction = $request->input('direction');

        // Lấy tất cả categories
        $categories = $this->categoryService->listCategory();

        // Lấy products với filters
        // $products = $this->productService->getProductWithVariant();
        $products = $this->productService->AdminFilterProducts($categoryId, $inStock, $sort, $direction);
        // Count total products
        $totalProducts = $products->count();
        // dd($categories);
        return view('Admin.adminProducts', compact('products', 'categories', 'totalProducts'));
    }
    public function getProductWithVariant($product_id)
    {
        $products = $this->productService->getProductWithVariantById($product_id);
        // dd($products);
        return view('Admin.adminVariantList', compact('products'));
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
