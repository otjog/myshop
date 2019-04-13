<?php

namespace App\Http\ViewComposers\Shop\Product;

use App\Models\Shop\Offer\Offer;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ShopOffersComposer{

    protected $offers;

    public function __construct(Offer $offers){

        $this->offers = Cache::remember('shop:offers:productsOffers|6', '60', function() use ($offers){
            return $offers->getProductsOffers(6);
        });

    }

    public function compose(View $view){
        $view->with('offers', $this->offers);
    }
}