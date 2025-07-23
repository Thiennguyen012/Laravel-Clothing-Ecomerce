<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\VariantService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $variantService;

    public function __construct(ProductService $productService, CategoryService $categoryService, VariantService $variantService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->variantService = $variantService;
    }

    public function showAll()
    {
        // Lấy tất cả categories
        $categories = $this->categoryService->listCategory();

        // Lấy products với filters
        $products = $this->productService->getProductWithVariant();

        // Count total products
        $totalProducts = $products->count();

        return view('products', compact('products', 'categories', 'totalProducts'));
    }
    public function showProductByCategoryId($id)
    {

        // Lấy tất cả categories
        $categories = $this->categoryService->listCategory();

        // Lấy products theo category
        // $products = $this->productService->showProductByCategoryId($id);
        $products = $this->productService->getProductWithVariantByCategoryId($id);
        // Tìm category hiện tại
        $currentCategory = $categories->where('category_id', $id)->first();

        // Nếu không tìm thấy category, redirect về products
        if (!$currentCategory) {
            return redirect()->route('products')->with('error', 'Danh mục không tồn tại');
        }

        // Count total products
        $totalProducts = $products->count();

        return view('category', compact('products', 'categories', 'currentCategory', 'totalProducts'));
    }
    public function getProductInAmount(Request $request, $categoryId = null, $minPrice, $maxPrice)
    {

        $productInAmount = $this->productService->getProductInAmount($categoryId, $minPrice, $maxPrice);
        if ($request->is('category*')) {
            return view('category', compact('productInAmount'));
        } elseif ($request->is('product*')) {
            return view('products', compact('productInAmount'));
        }
    }
    public function test()
    {
        return view('test');
    }
}
