<?php

namespace App\Models\Shop\Offer;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product\Product;
use App\Models\Settings;

class Offer extends Model{

    protected $table = 'shop_offers';

    public function products(){
        return $this->belongsToMany('App\Models\Shop\Product\Product', 'shop_offer_has_product', 'offer_id', 'product_id')
            ->withTimestamps();
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->settings = Settings::getInstance();

    }

    public function getProductsOffers($take = 10){

        $offers = $this->getActiveOffers();

        $newOffers = collect();

        $products = new Product();

        foreach($offers as $offer){

            if($offer->related){
                $offerProducts = $products->getCustomProductsOffer($offer->id, $take);

                $offer->relations = ['products' => $offerProducts];

            }else{
                $offerProducts = $products->getProductsPrepareOffer($offer->name, $take);

                $offer->relations = ['products' => $offerProducts];
            }

            $newOffers->put($offer->name, $offer);
        }
        unset($offers);
        return $newOffers;
    }

    //TODO поле name сделать уникальным
    public function getActiveOffers(){

        if($this->settings->getParameter('models.offers.activeOffers')){
            return $this->settings->getParameter('models.offers.activeOffers');
        }

        $result = self::select(
            'id',
            'name',
            'header',
            'related'
        )
            ->where('active', 1)
            ->get();

        $this->settings->addParameter('models.offers.activeOffers', $result);

        return $result;

    }

    public function getActiveOfferByName($name){

        if($this->settings->getParameter('models.offers.getActiveOfferByName|' . $name)){
            return $this->settings->getParameter('models.offers.getActiveOfferByName|' . $name);
        }

        $result = self::select(
            'id',
            'name',
            'header',
            'related'
        )
            ->where('active', 1)
            ->where('name', $name)
            ->get();

        $this->settings->addParameter('models.offers.getActiveOfferByName|' . $name, $result);

        return $result;

    }
}
