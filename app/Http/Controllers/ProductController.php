<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ICategoryService;
use App\Services\Interfaces\IProductService;
use App\Services\Interfaces\IVariantService;
use Illuminate\Http\Request;

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

    public function showAll(Request $request)
    {
        // lấy thông tin từ request
        $categoryId = $request->input('categoryId');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');
        $inStock = $request->input('inStock');
        $order = $request->input('order');

        // Lấy tất cả categories
        $categories = $this->categoryService->listCategory();

        // Lấy products với filters
        // $products = $this->productService->getProductWithVariant();
        $products = $this->productService->filterProducts($categoryId, $minPrice, $maxPrice, $inStock, $order);
        // Count total products
        $totalProducts = $products->count();
        // dd($categories);
        return view('products', compact('products', 'categories', 'totalProducts'));
    }

    public function getProductDetail($product_id)
    {
        $product = $this->productService->getProductDetail($product_id);

        // Lấy sản phẩm liên quan (cùng category, loại trừ sản phẩm hiện tại)
        $relatedProducts = null;
        if ($product && $product->category_id) {
            $relatedProducts = $this->productService->filterProducts($product->category_id)
                ->where('product_id', '!=', $product_id)
                ->take(4);
        }

        return view('singleProduct', compact('product', 'relatedProducts'));
    }
    // public function showProductByCategoryId($id)
    // {

    //     // Lấy tất cả categories
    //     $categories = $this->categoryService->listCategory();

    //     // Lấy products theo category
    //     // $products = $this->productService->showProductByCategoryId($id);
    //     $products = $this->productService->getProductWithVariantByCategoryId($id);
    //     // Tìm category hiện tại
    //     $currentCategory = $categories->where('category_id', $id)->first();

    //     // Nếu không tìm thấy category, redirect về products
    //     if (!$currentCategory) {
    //         return redirect()->route('products')->with('error', 'Danh mục không tồn tại');
    //     }

    //     // Count total products
    //     $totalProducts = $products->count();

    //     return view('category', compact('products', 'categories', 'currentCategory', 'totalProducts'));
    // }
    // public function getProductInAmount($minPrice, $maxPrice, $categoryId = null)
    // {
    //     // Lấy tất cả categories
    //     $categories = $this->categoryService->listCategory();

    //     // Lấy products theo khoảng giá và category (nếu có)
    //     $products = $this->productService->getProductInAmount($categoryId, $minPrice, $maxPrice);

    //     // Count total products
    //     $totalProducts = $products->count();

    //     // Nếu có categoryId, tìm current category
    //     if ($categoryId) {
    //         $currentCategory = $categories->where('category_id', $categoryId)->first();

    //         if (!$currentCategory) {
    //             return redirect()->route('products')->with('error', 'Danh mục không tồn tại');
    //         }

    //         return view('category', compact('products', 'categories', 'currentCategory', 'totalProducts'));
    //     }

    //     // Nếu không có category, hiển thị trang products với filter
    //     return view('products', compact('products', 'categories', 'totalProducts'));
    // }
    // public function getProductInStock($categoryId = null)
    // {
    //     // Lấy tất cả categories
    //     $categories = $this->categoryService->listCategory();

    //     // Lấy products theo khoảng giá và category (nếu có)
    //     $products = $this->productService->getProductInStock($categoryId);

    //     // Count total products
    //     $totalProducts = $products->count();

    //     // Nếu có categoryId, tìm current category
    //     if ($categoryId) {
    //         $currentCategory = $categories->where('category_id', $categoryId)->first();

    //         if (!$currentCategory) {
    //             return redirect()->route('products')->with('error', 'Danh mục không tồn tại');
    //         }

    //         return view('category', compact('products', 'categories', 'currentCategory', 'totalProducts'));
    //     }

    //     // Nếu không có category, hiển thị trang products với filter
    //     return view('products', compact('products', 'categories', 'totalProducts'));
    // }
    // public function sortProductNewest($categoryId = null)
    // {
    //     // Lấy tất cả categories
    //     $categories = $this->categoryService->listCategory();

    //     $products = $this->productService->sortProductNewest($categoryId);

    //     // Count total products
    //     $totalProducts = $products->count();

    //     // Nếu có categoryId, tìm current category
    //     if ($categoryId) {
    //         $currentCategory = $categories->where('category_id', $categoryId)->first();

    //         if (!$currentCategory) {
    //             return redirect()->route('products')->with('error', 'Danh mục không tồn tại');
    //         }

    //         return view('category', compact('products', 'categories', 'currentCategory', 'totalProducts'));
    //     }

    //     // Nếu không có category, hiển thị trang products với filter
    //     return view('products', compact('products', 'categories', 'totalProducts'));
    // }
    public function test()
    {
        return view('test');
    }
}
