<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $services=[
            \App\Services\AccountService::class,
            \App\Services\BannerService::class,
            \App\Services\CartService::class,
            \App\Services\CategoryService::class,
            \App\Services\DiscountService::class,
            \App\Services\HomeService::class,
            \App\Services\LocationService::class,
            \App\Services\OrderService::class,
            // \App\Services\ProductDiscountService::class,
            \App\Services\ProductService::class,
            // \App\Services\ProfileService::class,
        ];
        foreach ($services as $service) {
            $this->app->bind($service, function ($app) use ($service) {
                return new $service();
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.bootstrap-4');
    }
}
