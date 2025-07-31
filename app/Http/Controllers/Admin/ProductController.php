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
        $product_name = $request->input('product_name');
        $sort = $request->input('sort');
        $direction = $request->input('direction');

        // Lấy tất cả categories
        $categories = $this->categoryService->listCategory();

        // Lấy products với filters
        // $products = $this->productService->getProductWithVariant();
        $products = $this->productService->AdminFilterProducts($categoryId, $inStock, $product_name, $sort, $direction);
        // Count total products
        $totalProducts = $products->count();
        // dd($products);
        return view('Admin.adminProducts', compact('products', 'categories', 'totalProducts'));
    }
    public function getProductWithVariant(Request $request, $product_id)
    {
        // $product_id = $request->input('product_id');
        $sort = $request->input('sort');
        $direction = $request->input('direction');
        $products = $this->productService->getProductWithVariantById($product_id);
        $variants = $this->variantService->variantFilter($product_id, $sort, $direction);
        // dd($variants);
        return view('Admin.adminVariantList', compact('products', 'variants'));
    }
    public function newProduct(Request $request)
    {
        $this->productService->newProduct($request);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm thành công');
    }
    public function showNewProduct(Request $request)
    {
        $categories = $this->categoryService->listCategory();
        return view('Admin.adminNewProduct', compact('categories'));
    }
    public function updateProduct(Request $request)
    {
        $this->productService->updateProduct($request);
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }
    public function showUpdateProduct($id)
    {
        // $product_id = $request->input('id');
        $categories = $this->categoryService->listCategory();
        $product = $this->productService->getProductWithVariantById($id);
        return view('Admin.adminUpdateProduct', compact('product', 'categories'));
    }
    public function deleteProduct($product_id)
    {
        $this->productService->deleteProduct($product_id);
        return redirect()->back()->with('success', 'Xóa thành công!');
    }
}
