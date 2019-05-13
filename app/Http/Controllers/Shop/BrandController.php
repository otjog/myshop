<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop\Product\Brand;
use App\Libraries\Seo\MetaTagsCreater;
use App\Models\Site\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Order\Basket;
use App\Models\Settings;

class BrandController extends Controller{

    protected $brands;

    protected $baskets;

    protected $settings;

    protected $data;

    protected $globalData;

    protected $template;

    protected $metaTagsCreater;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct(Brand $brands, Basket $baskets, MetaTagsCreater $metaTagsCreater, Template $template)
    {

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

        $this->brands = $brands;

        $this->baskets = $baskets;

        $this->metaTagsCreater = $metaTagsCreater;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $this->data['template']['schema'] = $this->template->getTemplateWithContent('shop.brand.list');

        $this->data['brands']  = $this->brands->getActiveBrands();
        $this->data['header_page'] =  'Бренды';

        return view( $this->data['template']['name'] . '.components.shop.brand.list', $this->globalData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $products, $name){

        $this->data['template']['schema'] = $this->template->getTemplateWithContent('shop.brand.show');

        $brand = $this->brands->getBrand($name);

        $this->data['brand']       = $brand;
        $this->data['header_page'] = 'Товары бренда ' . $brand[0]->name;
        $this->data['parameters']  = [];

        if (count($request->query) > 0) {

            $routeData = ['brand' => $name];

            $filterData = $request->toArray();

            $this->data['products'] = $products->getFilteredProducts($routeData, $filterData);
        } else {
            $this->data['products'] = $products->getActiveProductsOfBrand($name);
        }

        $this->data['meta'] = $this->metaTagsCreater->getTagsForPage($this->data);

        return view( $this->data['template']['name'] . '.components.shop.brand.show', $this->globalData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
