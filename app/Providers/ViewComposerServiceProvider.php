<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(){
        $template = env('SITE_TEMPLATE');
        View::composers([
            'App\Http\ViewComposers\BannerComposer'         => $template . '.modules.banner.index',
            'App\Http\ViewComposers\Shop\Product\ShopOffersComposer' => $template . '.modules.offers.index',
            'App\Http\ViewComposers\ShopBasketComposer'     => $template . '.modules.shop_basket.index',
            'App\Http\ViewComposers\ProductFilterComposer'  => $template . '.modules.product_filter.index',
            'App\Http\ViewComposers\Shop\Delivery\DeliveryOffersComposer' => $template . '.modules.shipment.index',
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(){
        //
    }
}
