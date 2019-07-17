<?php

namespace App\Libraries\Delivery;

use App\Models\Shop\Product\Product;

class CustomDelivery
{
    private $geoData;

    public function __construct($geoData)
    {
        $this->geoData = $geoData;
    }

    public function getDeliveryCost($parcelParameters, $destinationType, $productIds)
    {
        $productIdsArray = explode('|', $productIds);

        /*
         * Мы создали параметр товара: Бесплатная доставка _free_ship_
         * Если у товара есть этот параметр, то:
         *   - на странице товара в калькуляторе доставки появится еще одно поле с доставкой До терминала за 0руб.
         *   - на странице оформление заказа доставка за 0руб. появится если хотя бы у одного из заказанных товаров есть параметр бесплатной доставки
         * Пока так!)
         */
        if($destinationType === 'toTerminal'){

            if($this->existsFreeShipProduct($productIdsArray)){
                return [
                    "type" => "toTerminal",
                    "price" => 0,
                    "days" => "~",
                    "service_id" => "free"
                ];
            }
        }
        return [];
    }

    public function getPointsInCity()
    {
        return [];
    }

    private function existsFreeShipProduct($productIdsArray)
    {
        $productModel = new Product();

        $products = $productModel
            ->whereIn('id', $productIdsArray)
            ->whereHas('parameters', function ($query) {
                $query->where('alias', '_free_delivery_');
            })
            ->get();

         return count($products);
    }

}
