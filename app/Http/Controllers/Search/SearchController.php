<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Order\Basket;
use sngrl\SphinxSearch\SphinxSearch;
use App\Models\Settings;

class SearchController extends Controller{

    protected $data = [];

    protected $settings;

    protected $products;

    protected $queryString;

    protected $baskets;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct(Request $request, Product $products, Basket $baskets){

        $this->settings = Settings::getInstance();

        $this->data['global_data']['project_data'] = $this->settings->getParameters();

        $this->products = $products;

        $this->baskets  = $baskets;

        $this->queryString    = $request->search;

        $this->data['parameters']  = $request->toArray();


    }

    public function show(){

        $this->data['template'] = config('template.content.shop.search.show');

        $sphinx  = new SphinxSearch();

        $searchIdResult = $sphinx->search($this->queryString, env( 'SPHINXSEARCH_INDEX' ))->query();

        $this->data['products']    = [];
        $this->data['query']       = $this->queryString;
        $this->data['header_page'] = 'Результаты поиска по запросу: ' . $this->queryString;

        if( isset( $searchIdResult[ 'matches' ] ) && count( $searchIdResult[ 'matches' ] ) > 0 ){
            $this->data['products'] = $this->products->getProductsById( array_keys( $searchIdResult[ 'matches' ] ) );
        }

        return view( $this->settings->data['template_name'] . '.components.shop.search.show', $this->data);
    }

}
