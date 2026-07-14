<?php

namespace App\Providers;

use App\Observers\BannerObserver;
use App\Observers\CategoryObserver;
use App\Observers\CouponObserver;
use App\Observers\ProductObserver;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            \App\Listeners\LogSuccessfulLogin::class,
        ],
        Logout::class => [
            \App\Listeners\LogSuccessfulLogout::class,
        ],
    ];

    public function boot(): void
    {
        Product::observe(ProductObserver::class);
        Category::observe(CategoryObserver::class);
        Coupon::observe(CouponObserver::class);
        Banner::observe(BannerObserver::class);
    }
}
