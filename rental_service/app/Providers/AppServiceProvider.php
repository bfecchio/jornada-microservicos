<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Observers\OrderObserver;
use App\Observers\OrderItemObserver;
use App\Observers\PaymentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}
