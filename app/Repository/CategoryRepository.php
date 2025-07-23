<?php

namespace App\Repository;

use App\Models\Category;
use App\Repository\Interfaces\ICategoryRepository;

class CategoryRepository extends BaseRepository implements ICategoryRepository
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
}
