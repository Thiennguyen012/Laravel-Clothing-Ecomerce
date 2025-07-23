<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\IProductService;
use App\Services\ProductService;
use App\Services\Interfaces\ICategoryService;
use App\Services\CategoryService;
use App\Services\Interfaces\IVariantService;
use App\Services\VariantService;

class ServicesProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductService::class, ProductService::class);
        $this->app->bind(ICategoryService::class, CategoryService::class);
        $this->app->bind(IVariantService::class, VariantService::class);
    }
}
