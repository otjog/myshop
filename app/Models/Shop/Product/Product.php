<?php

namespace App\Models\Shop\Product;

use  App\Models\Shop\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use JustBetter\PaginationWithHavings\PaginationWithHavings;
use App\Facades\GlobalData;

class Product extends Model
{
    use PaginationWithHavings;

    protected $fillable = ['brand_id', 'category_id', 'manufacturer_id', 'active', 'name', 'scu'];

    public function images()
    {
        return $this->morphToMany('App\Models\Site\Image', 'imageable');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Shop\Category\Category', 'category_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(    'App\Models\Shop\Product\Manufacturer');
    }

    public function prices()
    {
        return $this->belongsToMany('App\Models\Shop\Price\Price', 'product_has_price')->withPivot('value', 'currency_id')->withTimestamps();
    }

    public function stores()
    {
        return $this->belongsToMany('App\Models\Shop\Store\Store', 'shop_store_has_product')->withPivot('quantity')->withTimestamps();
    }

    public function marketplaces()
    {
        return $this->belongsToMany('App\Models\Shop\Marketplace', 'shop_marketplace_has_product')
            ->withTimestamps();
    }

    public function discounts()
    {
        return $this->belongsToMany('App\Models\Shop\Price\Discount', 'product_has_discount')->withPivot(['value', 'quantity'])->withTimestamps();
    }

    public function quantity_discounts()
    {
        return $this->belongsToMany('App\Models\Shop\Price\Discount', 'product_has_discount')->withPivot(['value', 'quantity'])->withTimestamps();
    }

    public function parameters()
    {
        return $this->belongsToMany('App\Models\Shop\Parameter\Parameter', 'product_has_parameter', 'product_id', 'parameter_id')->withPivot('id', 'value')->withTimestamps();
}

    public function basket_parameters()
    {
        return $this->belongsToMany('App\Models\Shop\Parameter\Parameter', 'product_has_parameter', 'product_id', 'parameter_id')->withPivot('id', 'value', 'basket_value')->withTimestamps();
    }

    public function baskets()
    {
        return $this->belongsToMany('App\Models\Shop\Order\Basket', 'shop_basket_has_product', 'product_id', 'basket_id')->withPivot('quantity', 'order_attributes')->withTimestamps();
    }

    public function offers()
    {
        return $this->belongsToMany('App\Models\Shop\Offer\Offer', 'shop_offer_has_product', 'product_id', 'offer_id')->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Shop\Order\Order', 'shop_order_has_product', 'product_id', 'order_id')
            ->withPivot('quantity', 'price_id', 'currency_id', 'price_value', 'order_attributes')
            ->withTimestamps();
    }
    /***Function***/
    public function getAllProducts(){
        return self::select(
            'products.id',
            'products.category_id',
            'products.active',
            'products.name',
            'products.original_name',
            'products.scu',
            'products.description',
            'products.unique'
        )
            ->orderBy('name')
            ->get();
    }

    /**
     * @param array $routeParameters Параметры маршрута в виде массива, например ['categories'=>21]
     * @param array $filterData Параметры фильтра (после знака "?") в виде массива
     * @param boolean|integer $chunk Значение пагинации для разделения товаров.
     * false - не делить товары
     * true - делить товары, значение по-умолчанию
     * число - делить товары на заданное число
     * @return object
     */
    public function getProductsFromRoute($routeParameters, $filterData = [], $chunk = true)
    {
        /**
         * Получаем обшие данные для всех роутов
         */
        $productsQuery = $this->getListProductQuery();

        /**
         * Фильтруем товары, если есть данные фильтра
         */
        $products = $this->filterByFormParameters($productsQuery, $filterData);

        /**
         * Фильтруем по параметрам роута
         */
        $products = $this->filterByRouteParameter($products, $routeParameters);

        /**
         * Сортируем и разбиваем на страницы
         */
        $products = $products->orderBy('products.name');

        if ($chunk === false) {
            $products = $products->get();
        } else {
            $chunk = GlobalData::getParameter('components.shop.pagination');
            $products = $products->paginate($chunk);
        }


        $products = $this->addLeftJoinsAsRelationCollections($products);
        $products = $this->calculateQuantityDiscounts($products);
        $products = $this->changePriceIfExistQuantityDiscount($products);

        return $products;
    }

    public function getProductsById($idProducts)
    {
        $pagination = GlobalData::getParameter('components.shop.pagination');

        $productsQuery = $this->getListProductQuery();

        $products = $productsQuery

            ->whereIn('products.id', $idProducts)

            ->orderBy('products.name')

            ->paginate($pagination);

        $products = $this->addLeftJoinsAsRelationCollections($products);
        $products = $this->calculateQuantityDiscounts($products);
        $products = $this->changePriceIfExistQuantityDiscount($products);
        return $products;

    }

    public function getProductsFromBasket($basket_id){

        $productsQuery = $this->getListProductQuery();

        $products =  $productsQuery->addSelect(
            'products.weight',
            'products.length',
            'products.width',
            'products.height',
            'shop_basket_has_product.basket_id          as pivot|basket_id',
            'shop_basket_has_product.product_id         as pivot|product_id',
            'shop_basket_has_product.quantity           as pivot|quantity',
            'shop_basket_has_product.order_attributes   as pivot|order_attributes'
        )
            ->where('products.active', 1)

            /************IN_BASKET**************/
            ->join('shop_basket_has_product', function ($join) use ($basket_id) {
                $join->on('products.id', '=', 'shop_basket_has_product.product_id')
                    ->where('shop_basket_has_product.basket_id', $basket_id);
            })
            ->join('shop_baskets', 'shop_baskets.id', '=', 'shop_basket_has_product.basket_id')

            ->orderBy('shop_basket_has_product.id')

            ->get();

        $products = $this->addLeftJoinsAsRelationCollections($products);

        $products = $this->addSelectedOrderAttributeToPivot($products, 'basket');

        $products = $this->changePriceIfExistQuantityDiscount($products);

        return $products;
    }

    public function getProductsFromOrder($order_id)
    {
        $products =  self::select(
            'products.id',
            'products.manufacturer_id',
            'products.category_id',
            'products.name',
            'products.original_name',
            'products.scu',
            'products.weight',
            'products.length',
            'products.width',
            'products.height',
            'prices.id                      as price|id',
            'prices.name                    as price|name',
            'currency.value                 as price|pivot|currency_value',
            'currency.char_code             as price|pivot|currency_code',
            'currency.id                    as price|pivot|currency_id',
            'manufacturers.id               as manufacturer|id',
            'manufacturers.name             as manufacturer|name',
            'shop_order_has_product.order_id           as pivot|order_id',
            'shop_order_has_product.product_id         as pivot|product_id',
            'shop_order_has_product.quantity           as pivot|quantity',
            'shop_order_has_product.price_id           as pivot|price_id',
            'shop_order_has_product.currency_id        as pivot|currency_id',
            'shop_order_has_product.price_value        as price|value',
            'shop_order_has_product.order_attributes   as pivot|order_attributes'
        )

            /************IN_ORDER**************/
            ->join('shop_order_has_product', function ($join) use ($order_id) {
                $join->on('products.id', '=', 'shop_order_has_product.product_id')
                    ->where('shop_order_has_product.order_id', $order_id);
            })
            ->join('shop_orders', 'shop_orders.id', '=', 'shop_order_has_product.order_id')

            /************PRICE*******************/
            ->leftJoin('prices','prices.id', '=', 'shop_order_has_product.price_id')

            /************CURRENCY****************/
            ->leftJoin('currency', 'currency.id', '=', 'shop_order_has_product.currency_id')

            /************MANUFACTURER***********/
            ->leftJoin('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')

            /************PARAMETERS*************/
            ->with(['basket_parameters' => function ($query) {
                $query->where('product_parameters.order_attr', '=', 1);
            }])

            ->orderBy('shop_order_has_product.id')

            ->get();

        $products = $this->addLeftJoinsAsRelationCollections($products);

        return $this->addSelectedOrderAttributeToPivot($products, 'order');

    }

    public function getJsonParcelParameters($products)
    {
        $parcelData = [
            'products_id' => [],
            'parcel' => [],
            'declaredValue' => 0
        ];

        foreach ($products as $product) {
            $parcelData['products_id'][] = $product->id;
            $parcelData['parcel'][] = $this->getParametersForParcel($product);
            $parcelData['declaredValue'] += $product->price['value'];
        }

        return json_encode($parcelData);
    }

    private function getParametersForParcel($product)
    {
        if(!isset($product->quantity) && $product->quantity === null)
            $product->quantity = 1;

        return [
            'weight'    => $product->weight,
            'length'    => $product->length,
            'width'     => $product->width,
            'height'    => $product->height,
            'quantity'  => $product->quantity,

        ];
    }

    private function addLeftJoinsAsRelationCollections($products)
    {
        foreach ( $products as $product){

            foreach ($product->original as $key => $value){

                $match = explode('|', $key, 3);

                switch($match[0]){

                    case 'price'       :
                    case 'category'    :
                    case 'discounts'   :
                    case 'manufacturer':
                    case 'parameters':
                    case 'baskets':
                    case 'pivot':

                        if( !isset($data[ $match[0] ]) ){
                            $data[ $match[0] ] = [] ;
                        }

                        switch( $match[1] ){
                            case 'pivot'    : $data[ $match[0] ] [ $match[1] ] [ $match[2] ] = $value; break;
                            default         : $data[ $match[0] ] [ $match[1] ] = $value; break;
                        }
                        $product->relations[ $match[0] ] = collect($data[ $match[0] ]);

                        break;
                }

            }

        }

        return $products;
    }

    private function getListProductQuery()
    {
        $today = GlobalData::getParameter('today');

        $price_id = GlobalData::getParameter('components.shop.customer_group.price_id');

        return self::select(
            'products.id',
            'products.manufacturer_id',
            'products.category_id',
            'products.name',
            'products.original_name',
            'products.scu',
            'products.description',
            'products.weight',
            'products.length',
            'products.width',
            'products.height',
            'prices.id                      as price|id',
            'prices.name                    as price|name',
            'product_has_price.value        as price|pivot|value',
            'currency.value                 as price|pivot|currency_value',
            'currency.char_code             as price|pivot|currency_code',
            'currency.id                    as price|pivot|currency_id',
            'discounts.id                   as discounts|id',
            'discounts.name                 as discounts|name',
            'discounts.type                 as discounts|type',
            'product_has_discount.value     as discounts|pivot|value',
            'product_has_discount.quantity  as discounts|pivot|quantity',
            'manufacturers.id               as manufacturer|id',
            'manufacturers.name             as manufacturer|name',

            DB::raw(
                'CASE discounts.type
                           WHEN "percent"
                                    THEN ROUND( ( product_has_price.value - (product_has_price.value / 100 * product_has_discount.value) ) * currency.value )
                           WHEN "value"
                                    THEN ROUND( (product_has_price.value - product_has_discount.value) * currency.value )
                           ELSE ROUND( product_has_price.value * currency.value )
                        END AS "price|value"'
            ),
            DB::raw(
                'CASE discounts.type
                           WHEN "percent"
                                    THEN ROUND( product_has_price.value / 100 * product_has_discount.value * currency.value )
                           WHEN "value"
                                    THEN ROUND( product_has_discount.value * currency.value )
                           ELSE 0
                        END AS "price|sale"'
            )
        )

            ->where('products.active', 1)

            /************PRICE******************/
            ->leftJoin('product_has_price', function ($join) use ($price_id) {
                $join->on('products.id', '=', 'product_has_price.product_id')
                    ->where('product_has_price.active', '=', '1')
                    ->where('product_has_price.price_id', '=', $price_id);
            })
            ->leftJoin('prices','prices.id', '=', 'product_has_price.price_id')

            /************CURRENCY***************/
            ->leftJoin('currency', 'currency.id', '=', 'product_has_price.currency_id')

            /************DISCOUNT***************/
            //->leftJoin('product_has_discount', 'products.id', '=', 'product_has_discount.product_id')
            ->leftJoin('product_has_discount', function ($join) {
                $join->on('products.id', '=', 'product_has_discount.product_id')
                    ->where('product_has_discount.quantity', '=', '1');
            })
            ->leftJoin('discounts', function ($join) use ($today, $price_id) {
                $join->on('discounts.id', '=', 'product_has_discount.discount_id')
                    ->where('discounts.active', '=', '1')
                    ->where('discounts.price_id', '=', $price_id)
                    ->whereDate('to_date', '>=', $today);
            })

            /********QUANTITY DISCOUNT**********/
            ->with(['quantity_discounts' => function ($query) use ($price_id) {
                $query->where('product_has_discount.quantity', '>', 1)
                    ->where('discounts.price_id', '=', $price_id)
                    ->orderBy('product_has_discount.quantity');
            }])

            /************MANUFACTURER***********/
            ->leftJoin('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')

            /*********BASKET*PARAMETERS*********/
            ->with(['basket_parameters' => function ($query) {
                $query->where('product_parameters.order_attr', '=', 1);
            }])

            /************PARAMETERS*************/
            ->with(['parameters' => function ($query) {
                $query->where('product_parameters.order_attr', '=', 0);
            }])

            /************STORES*****************/
            ->with(['stores' => function ($query) {
                $query->where('shop_stores.active', '=', 1)
                    ->where('shop_store_has_product.active', '=', 1)
                    ->where('shop_store_has_product.quantity', '>', 0);
            }])

            /************BASKET*****************/
            ->with(['baskets' => function($query)
            {
                $query->where('token', session('_token'));
            }])

            /************CATEGORY***************/
            ->with('category')

            /************IMAGES*****************/
            ->with('images');
    }

    public function getCustomProductsOffer($offer_id, $take){

        $productsQuery = $this->getListProductQuery();

        $products = $productsQuery

            /************OFFERS****************/
            ->rightJoin('shop_offer_has_product', function ($join) use ($offer_id){
                $join->on('shop_offer_has_product.product_id', '=', 'products.id')
                    ->where('shop_offer_has_product.offer_id', '=', $offer_id);
            })

            ->where('products.active', 1)

            ->orderBy('products.name')

            ->take($take)

            ->get();

        return $this->addLeftJoinsAsRelationCollections($products);
    }

    public function getProductsPrepareOffer($offer_name, $take){

        switch($offer_name){
            case 'sale' :
                $productQuery = $this->getListProductQuery();

                $products = $productQuery
                    ->where('products.active', 1)

                    ->where('discounts.id', '<>', NULL)

                    ->orderBy('products.name')

                    ->take($take)

                    ->get();

                return $this->addLeftJoinsAsRelationCollections($products);

            case 'newest' :
                $productQuery = $this->getListProductQuery();

                $products = $productQuery
                    ->where('products.active', 1)

                    ->orderBy('products.created_at')

                    ->take($take)

                    ->get();

                return $this->addLeftJoinsAsRelationCollections($products);
        }

    }

    private function addSelectedOrderAttributeToPivot($products, $model)
    {
        foreach($products as $key => $product){

            $attributes = explode(',', $product['pivot']['order_attributes']);

            $parameters = $product->basket_parameters;

            $temporary = [];

            foreach($attributes as $attribute){

                foreach($parameters as $parameter){
                    if($parameter->pivot->id === (int)$attribute){
                        $temporary[] = $parameter;
                        switch ($model) {
                            case 'basket' :
                                $product['price|value'] += $parameter->pivot->basket_value;
                                $product->price['value'] += $parameter->pivot->basket_value;
                                break;
                            case 'order' :
                                break;
                        }

                    }
                }

            }

            $product['pivot']['order_attributes_collection'] = $temporary;

            $product->quantity = $product['pivot']['quantity'];
        }
        return $products;
    }

    private function changePriceIfExistQuantityDiscount($products)
    {
        foreach ($products as $product) {

            if (isset($product->quantity_discounts) && $product->quantity_discounts !== null && count($product->quantity_discounts) > 0) {
                $quantityDiscounts = $product->quantity_discounts;

                if (isset($product->baskets[0]) && $product->baskets[0] !== null) {
                    $quantityDiscounts = $quantityDiscounts->filter(function ($value, $key) use ($product)  {
                        return $value->pivot->quantity <= $product->baskets[0]['pivot']['quantity'];
                    });

                    $quantityDiscounts = $quantityDiscounts->sortByDesc(function ($value, $key) {
                        return $value->pivot->quantity;

                    });

                    $quantityDiscount = $quantityDiscounts->first();

                    if ($quantityDiscount !== null) {

                        switch ($quantityDiscount->type) {
                            case 'percent' :
                                if($quantityDiscount->pivot->value > 99)
                                    break;

                                $product->price['sale'] =
                                $product['price|sale']  =
                                    (int)($product['price|value'] / 100 * $quantityDiscount->pivot->value);

                                $product->price['value'] =
                                $product['price|value'] =
                                    $product['price|value'] - $product->price['sale'];
                                break;

                            case 'value' :
                                if($quantityDiscount->pivot->value * $product->price['pivot']['currency_value'] >= $product->price['value'] )
                                    break;

                                $product->price['sale'] =
                                $product['price|sale'] =
                                    (int)($quantityDiscount->pivot->value * $product->price['pivot']['currency_value']);

                                $product['price|value'] -= $product->price['sale'];
                                $product->price['value'] -= $product->price['sale'];
                                break;
                        }
                    }
                }

            }
        }
        return $products;
    }

    protected function calculateQuantityDiscounts($products)
    {
        foreach ($products as $product) {

            if (isset($product->quantity_discounts) && $product->quantity_discounts !== null && count($product->quantity_discounts) > 0) {

                $quantityDiscounts = $product->quantity_discounts;

                foreach ($quantityDiscounts as $quantityDiscount) {
                    switch ($quantityDiscount->type) {
                        case 'percent' :

                            if($quantityDiscount->pivot->value > 99)
                                break;

                            $quantityDiscount->pivot['totalSale'] =
                                (int)($product->price['value'] / 100 * $quantityDiscount->pivot->value);

                            $quantityDiscount->pivot['totalPrice'] =
                                $product->price['value'] - $quantityDiscount->pivot['totalSale'];
                            break;
                        case 'value' :

                            if($quantityDiscount->pivot->value * $product->price['pivot']['currency_value'] >= $product->price['value'] )
                                break;

                            $quantityDiscount->pivot['totalSale'] =
                                (int)($quantityDiscount->pivot->value * $product->price['pivot']['currency_value']);

                            $quantityDiscount->pivot['totalPrice'] = $product->price['value'] - $quantityDiscount->pivot['totalSale'];
                            break;
                    }
                }
            }
        }
        return $products;
    }

    protected function filterByFormParameters($productsQuery, $filterData)
    {
        $filter_prefix = GlobalData::getParameter('components.shop.filter_prefix');

        $products = $productsQuery
            /************PRICE*******************/
            ->when(isset($filterData['price']), function ($query) use ($filterData) {
                return $query->having('price|value', '>=', ($filterData['price']["0"]))
                    ->having('price|value', '<=', ($filterData['price']["1"]));
            })

            /************MANUFACTURER***********/
            ->when(isset($filterData['manufacturer']), function ($query) use ($filterData) {
                return $query->whereIn('products.manufacturer_id', $filterData['manufacturer']);
            })

            /************CATEGORY***************/
            ->when(isset($filterData['category']), function ($query) use ($filterData) {
                return $query->whereIn('products.category_id', $filterData['category']);
            });

        /************PARAMETERS*************/
        foreach($filterData as $key => $parameter){

            if(strpos($key, $filter_prefix) === 0){
                $key = str_replace($filter_prefix, '', $key);
                $products = $products->whereHas('parameters', function($query) use ($parameter, $key) {
                    $query->where('product_parameters.alias', '=', $key)
                        ->whereIn('product_has_parameter.value', $parameter);
                });
            }

        }

        return $products;
    }

    protected function filterByRouteParameter($products, $routeParameters)
    {
        foreach ($routeParameters as $key => $id) {
            switch ($key) {
                case 'product' :
                    $products = $products->where('products.id', '=', $id);
                    break;
                case 'category' :
                    $products = $products->where('products.category_id', $id);
                    break;
                case 'brand' :
                    $products = $products->rightJoin('product_has_parameter', function ($join) use ($id) {
                        $join->on('products.id', '=', 'product_has_parameter.product_id')
                            ->where('product_has_parameter.value', '=', $id);
                    });
                    break;
                case 'marketplace' :
                    $products = $products->rightJoin('shop_marketplace_has_product', function ($join) use ($id) {
                        $join->on('products.id', '=', 'shop_marketplace_has_product.product_id')
                            ->where('shop_marketplace_has_product.marketplace_id', '=', $id);
                    });
                    break;
            }
        }
        return $products;
    }
}
