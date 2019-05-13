<?php

namespace App\Http\Controllers\Search;

use App\Models\Site\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Order\Basket;
use sngrl\SphinxSearch\SphinxSearch;
use App\Models\Settings;

class SearchController extends Controller{

    protected $globalData;

    protected $data;

    protected $template;

    protected $settings;

    protected $products;

    protected $queryString;

    protected $baskets;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct(Request $request, Product $products, Basket $baskets, Template $template){

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

        $this->products = $products;

        $this->baskets  = $baskets;

        $this->queryString    = $request->search;

        $this->data['parameters']  = $request->toArray();


    }

    public function show(){

        $this->data['template'] = $this->template->getTemplateWithContent('shop.search.show');

        $sphinx  = new SphinxSearch();

        $searchIdResult = $sphinx->search($this->queryString, env( 'SPHINXSEARCH_INDEX' ))->query();

        $this->data['products']    = [];
        $this->data['query']       = $this->queryString;
        $this->data['header_page'] = 'Результаты поиска по запросу: ' . $this->queryString;

        if( isset( $searchIdResult[ 'matches' ] ) && count( $searchIdResult[ 'matches' ] ) > 0 ){
            $this->data['products'] = $this->products->getProductsById( array_keys( $searchIdResult[ 'matches' ] ) );
        }

        return view( $this->data['template']['name'] . '.components.shop.search.show', $this->globalData);
    }

}
