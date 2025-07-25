<?php

namespace App\Providers;

use App\Repository\CartRepository;
use Illuminate\Support\ServiceProvider;
use App\Repository\Interfaces\IProductRepository;
use App\Repository\ProductRepository;
use App\Repository\Interfaces\ICategoryRepository;
use App\Repository\CategoryRepository;
use App\Repository\Interfaces\ICartRepository;
use App\Repository\Interfaces\IOrderItemRepository;
use App\Repository\Interfaces\IOrderRepository;
use App\Repository\Interfaces\IVariantRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Repository\VariantRepository;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(IVariantRepository::class, VariantRepository::class);
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
        $this->app->bind(IOrderItemRepository::class, OrderItemRepository::class);
        $this->app->bind(ICartRepository::class, CartRepository::class);
    }
}
