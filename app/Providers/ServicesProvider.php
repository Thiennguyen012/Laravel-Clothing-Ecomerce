<?php

namespace App\Providers;

use App\Services\Interfaces\ICartService;
use App\Services\CartService;
use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\IProductService;
use App\Services\ProductService;
use App\Services\Interfaces\ICategoryService;
use App\Services\CategoryService;
use App\Services\Interfaces\IOrderItemService;
use App\Services\Interfaces\IOrderService;
use App\Services\Interfaces\IUserService;
use App\Services\Interfaces\IVariantService;
use App\Services\OrderItemService;
use App\Services\OrderService;
use App\Services\UserService;
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
        $this->app->bind(ICartService::class, CartService::class);
        $this->app->bind(IOrderService::class, OrderService::class);
        $this->app->bind(IOrderItemService::class, OrderItemService::class);
        $this->app->bind(IUserService::class, UserService::class);
    }
}
