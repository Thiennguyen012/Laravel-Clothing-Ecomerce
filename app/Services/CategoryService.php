<?php

namespace App\Services;

use App\Repository\Interfaces\ICategoryRepository;
use App\Services\Interfaces\ICategoryService;

class CategoryService implements ICategoryService
{
    protected $categoryRepository;
    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function viewCategory($id)
    {
        $category = $this->categoryRepository->findOne(['category_id' => $id]);
        return $category;
    }
    public function listCategory()
    {
        $condititons = [];
        $categories = $this->categoryRepository->find($condititons);
        return $categories;
    }
}
