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
            'App\Http\ViewComposers\ModelsMenuComposer' => $template . '.index',
            'App\Http\ViewComposers\ShopBasketComposer'     => $template . '.modules.shop_basket.default',
            'App\Http\ViewComposers\ProductFilterComposer'  => $template . '.modules.product_filter.default',
            'App\Http\ViewComposers\BannerComposer'         => $template . '.modules.banner.default',

            'App\Http\ViewComposers\Shop\Product\ShopOffersComposer' => $template . '.modules.offers.default',
            'App\Http\ViewComposers\Shop\Delivery\DeliveryOffersComposer' => $template . '.modules.shipment.default',
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
