<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Order\Basket;
use Illuminate\Http\Request;
use App\Models\Shop\Product\Product;
use App\Libraries\Seo\MetaTagsCreater;
use App\Models\Settings;
use App\Models\Site\Photo360;

class ProductController extends Controller{

    protected $products;

    protected $baskets;

    protected $metaTagsCreater;

    protected $settings;

    protected $data = [];

    /**
     * Создание нового экземпляра контроллера.
     *
     * @param  Product $products
     * @return void
     */
    public function __construct(Product $products, Basket $baskets, MetaTagsCreater $metaTagsCreater ){

        $this->settings = Settings::getInstance();

        $this->data['global_data']['project_data'] = $this->settings->getParameters();

        $this->products = $products;

        $this->baskets = $baskets;

        $this->metaTagsCreater = $metaTagsCreater;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        $photo360 = new Photo360();

        $this->data['template'] = config('template.content.shop.product.show');

        $this->data['product'] = $this->products->getActiveProduct($id);

        $this->data['photo360'] = $photo360->getPhotos($this->data['product']['scu']);

        $this->data['meta'] = $this->metaTagsCreater->getTagsForPage($this->data);

        return view( '_raduga.components.shop.product.show', $this->data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
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
    public function destroy($id){
        //
    }

}